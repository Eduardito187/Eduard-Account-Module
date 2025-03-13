<?php

namespace Eduard\Account\Helpers\Account;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Eduard\Account\Events\SendEmailConfirmRestorePassword;
use Eduard\Account\Events\SendEmailRestorePassword;
use Eduard\Account\Helpers\SendMail;
use Eduard\Account\Models\ContactClient;
use Eduard\Account\Models\NotificationsClient;
use Eduard\Account\Models\PasswordReset;
use Eduard\Account\Helpers\System\CoreHttp;
use Eduard\Account\Models\CustomersAccount;

class Customer
{
    protected $coreHttp;

    public function __construct(
        CoreHttp $coreHttp
    ) {
        $this->coreHttp = $coreHttp;
    }

    public function closeSession(array $body, array $header = [])
    {
        return $this->executeWithValidation(
            function() use ($header) {
                $this->validateCustomerKey($header);
                $this->removeCookie("customer_backend");
                return [];
            },
            "Proceso ejecutado exitosamente."
        );
    }

    public function removeCookie(string $key)
    {
        unset($_COOKIE[$key]);
    }

    public function setCookie(string $key, string $value)
    {
        $_COOKIE[$key] = $value;
    }

    public function getCustomerInformation(array $body, array $header = [])
    {
        return $this->executeWithValidation(
            function() use ($header) {
                $this->validateCustomerKey($header);
                return $this->getCustomerArrayByEncryption($header["customer-key"][0]);
            },
            "Proceso ejecutado exitosamente."
        );
    }

    public function customerValidateLogin(array $body, array $header = [])
    {
        return $this->executeWithValidation(
            function() use ($body) {
                $this->validateLoginParams($body);
                return $this->validateLoginAccount($body["mail"], $body["password"]);
            },
            "Proceso ejecutado exitosamente."
        );
    }

    public function customerResetPassword(array $body, array $header = [])
    {
        return $this->executeWithValidation(
            function() use ($body) {
                $this->validateResetPasswordParams($body);
                return [];
            },
            "Proceso ejecutado exitosamente."
        );
    }

    public function executeWithValidation(callable $callback, string $successMessage)
    {
        try {
            $result = $callback();
            return $this->coreHttp->constructResponse($result, $successMessage, 200, true);
        } catch (Exception $e) {
            return $this->coreHttp->constructResponse([], $e->getMessage(), 500, false);
        }
    }

    private function validateLoginParams(array $body)
    {
        if (!isset($body["password"]) || !isset($body["mail"])) {
            throw new Exception("Parametros no validos.");
        }
    }

    public function sendConfirmRestorePassword($email)
    {
        new SendMail("mail.reset-password", $email, "Restauracion de contraseña.", [
            "title" => "Contraseña restaurada",
            "footer_text" => "Felicidades tu contraseña ha sido restaurada exitosamente."
        ]);
    }

    public function sendEventRestorePassword($mail)
    {
        Event::dispatch(new SendEmailRestorePassword($mail));
    }

    public function sendEventConfirmRestorePassword($mail)
    {
        Event::dispatch(new SendEmailConfirmRestorePassword($mail));
    }

    public function proccessRestorePassword($email)
    {
        $token = Str::random(60);
        PasswordReset::updateOrCreate(
            ['email' => $email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        new SendMail("mail.confirmation-password", $email, "Restauracion de contraseña.", [
            "title" => "Restaura tu contraseña",
            "description" => "Haga clic aquí para restablecer la contraseña.",
            "footer_text" => "Si esto fue un error, simplemente ignora este correo electrónico y no pasará nada.",
            "token" => $token
        ]);
    }

    private function validateResetPasswordParams(array $body)
    {
        if (!isset($body["mail"])) {
            throw new Exception("Parametros no validos.");
        }

        $customer = $this->getCustomerByMail($body["mail"]);

        if ($customer == null) {
            throw new Exception("Customer no identificado.");
        }

        $this->sendEventRestorePassword($customer->mail);
    }

    public function getCustomerByMail(string $mail)
    {
        return CustomersAccount::where('mail', $mail)->first();
    }

    public function validateCustomerKey(array $header)
    {
        if (
            !isset($header["customer-key"]) ||
            !is_array($header["customer-key"]) ||
            count($header["customer-key"]) === 0
        ) {
            throw new Exception("Parametros no validos.");
        }

        $this->validateCustomerEncryption($header["customer-key"][0]);
    }

    private function validateCustomerEncryption(string $keyEncryption)
    {
        $descryptionMail = $this->decrypt($keyEncryption);
        $customer = $this->getCustomerByMail($descryptionMail);

        if (is_null($customer)) {
            throw new Exception("Customer no identificado.");
        }

        return true;
    }

    public function getCustomerByEncryption(string $keyEncryption)
    {
        $descryptionMail = $this->decrypt($keyEncryption);
        $customer = $this->getCustomerByMail($descryptionMail);

        if (is_null($customer)) {
            throw new Exception("Customer no identificado.");
        }

        return $customer;
    }

    public function getCustomerArrayByEncryption(string $keyEncryption)
    {
        $customer = $this->getCustomerByEncryption($keyEncryption);
        return $this->entityCustomerArray($customer);
    }

    public function entityCustomerArray(CustomersAccount $customer)
    {
        $customerAccountInformation = $customer->customerAccountInformation;

        return [
            'mail' => $customer->mail,
            'status' => $customer->status,
            'first_name' => $customerAccountInformation->first_name,
            'last_name' => $customerAccountInformation->last_name,
            'phone_number' => $customerAccountInformation->phone_number,
            'company' => $customerAccountInformation->company
        ];
    }

    public function validateLoginAccount(string $mail, string $password)
    {
        $customer = $this->getCustomerByMail($mail);

        if ($customer && $customer->password === $this->encryptedPawd($password)) {
            $encryptKey = $this->encrypt($mail);
            $this->setCookie("customer_backend", $encryptKey);

            return ["message" => 'Inicio de sesión exitoso.', "status" => true, 'customer' => $encryptKey];
        }

        return ["message" => 'Credenciales no válidas.', "status" => false];
    }

    public function validateBodyMail(array $body)
    {
        $requiredFields = [
            'name',
            'description',
            'mail_template',
            'selectedIndex',
            'timeExecute',
            'previewMail'
        ];

        foreach ($requiredFields as $field) {
            if (!isset($body[$field]) || $body[$field] === null) {
                throw new Exception("Parametros no validos.");
            }
        }
    }

    public function createNotificationClient($idClient)
    {
        try {
            $notification = new NotificationsClient();
            $notification->report_day = false;
            $notification->report_month = false;
            $notification->alert_usage = false;
            $notification->alert_billing = false;
            $notification->ai = false;
            $notification->id_client = $idClient;
            $notification->created_at = date("Y-m-d H:i:s");
            $notification->updated_at = null;
            $notification->save();
        } catch (Exception $e) {
            return null;
        }
    }

    public function createContactClient($idClient, $body)
    {
        try {
            $contact = new ContactClient();
            $contact->name_privacy = $body["name_privacy"] ?? "";
            $contact->phone_privacy = $body["phone_privacy"] ?? "";
            $contact->mail_privacy = $body["mail_privacy"] ?? "";
            $contact->mail_security = $body["mail_security"] ?? "";
            $contact->id_client = $idClient;
            $contact->created_at = date("Y-m-d H:i:s");
            $contact->updated_at = null;
            $contact->save();
        } catch (Exception $e) {
            return null;
        }
    }

    public function getConfigContacts(array $body, array $header = [])
    {
        return $this->executeWithValidation(
            function() use ($header, $body) {
                $this->validateCustomerKey($header);
                $customer = $this->getCustomerByEncryption($header["customer-key"][0]);
                $client = $customer->client;

                if (!$client->contactClient) {
                    $this->createContactClient($client->id, $body);
                }

                $data = [
                    "name_privacy" => $client->contactClient->name_privacy ?? "",
                    "phone_privacy" => $client->contactClient->phone_privacy ?? "",
                    "mail_privacy" => $client->contactClient->mail_privacy ?? "",
                    "mail_security" => $client->contactClient->mail_security ?? ""
                ];

                return $data;
            },
            "Proceso ejecutado exitosamente."
        );
    }

    public function setConfigContacts(array $body, array $header = [])
    {
        return $this->executeWithValidation(
            function() use ($header, $body) {
                $this->validateCustomerKey($header);
                $customer = $this->getCustomerByEncryption($header["customer-key"][0]);
                $client = $customer->client;

                if (!$client->contactClient) {
                    $this->createContactClient($client->id, $body);
                } else {
                    $contact = $client->contactClient;
                    $contact->name_privacy = $body["name_privacy"] ?? "";
                    $contact->phone_privacy = $body["phone_privacy"] ?? "";
                    $contact->mail_privacy = $body["mail_privacy"] ?? "";
                    $contact->mail_security = $body["mail_security"] ?? "";
                    $contact->updated_at = date("Y-m-d H:i:s");
                    $contact->save();
                }

                return ["status" => true];
            },
            "Proceso ejecutado exitosamente."
        );
    }

    public function getConfigNotifications(array $body, array $header = [])
    {
        return $this->executeWithValidation(
            function() use ($header, $body) {
                $this->validateCustomerKey($header);
                $customer = $this->getCustomerByEncryption($header["customer-key"][0]);
                $client = $customer->client;

                if (!$client->notificationClient) {
                    $this->createNotificationClient($client->id);
                }

                $data = [
                    "report_day" => boolval($client->notificationClient->report_day ?? false),
                    "report_month" => boolval($client->notificationClient->report_month ?? false),
                    "alert_usage" => boolval($client->notificationClient->alert_usage ?? false),
                    "alert_billing" => boolval($client->notificationClient->alert_billing ?? false),
                    "ai" => boolval($client->notificationClient->ai ?? false)
                ];

                return $data;
            },
            "Proceso ejecutado exitosamente."
        );
    }

    public function setConfigNotifications(array $body, array $header = [])
    {
        return $this->executeWithValidation(
            function() use ($header, $body) {
                $this->validateCustomerKey($header);
                $customer = $this->getCustomerByEncryption($header["customer-key"][0]);
                $client = $customer->client;

                if (isset($body["code"])) {
                    if (!$client->notificationClient) {
                        $this->createNotificationClient($client->id);
                    } else {
                        NotificationsClient::where('id_client', $client->id)->update(
                            [
                                $body["code"] => $body["value"] ?? false,
                                'updated_at' => date("Y-m-d H:i:s")
                            ]
                        );
                    }
                }

                return ["status" => true];
            },
            "Proceso ejecutado exitosamente."
        );
    }

    public function getAllKeys(array $body, array $header = [])
    {
        return $this->executeWithValidation(
            function() use ($header, $body) {
                $this->validateCustomerKey($header);
                $customer = $this->getCustomerByEncryption($header["customer-key"][0]);
                $client = $customer->client;
                $data = [];

                foreach ($client->indexes as $index) {
                    $data[] = [
                        "code" => $index->code,
                        "name" => $index->name,
                        "token" => $index->indexConfiguration->api_key ?? ''
                    ];
                }

                return [
                    "client_token" => $client->autorizationToken->token,
                    "code" => $client->name,
                    "name" => $client->code,
                    "index" => $data
                ];
            },
            "Proceso ejecutado exitosamente."
        );
    }

    public function generatePasswordCustomer(array $body, array $header = [])
    {
        return $this->executeWithValidation(
            function() use ($body) {
                if (!isset($body["password"])) {
                    throw new Exception("Parametros no validos.");
                }

                return ["password" => $this->encryptedPawd($body["password"])];
            },
            "Proceso ejecutado exitosamente."
        );
    }

    public function encryptedPawd(string $password)
    {
        return hash_hmac('sha256', $password, env('ENCRYPTION_KEY'));
    }

    private function encrypt($data)
    {
        $iv = str_repeat('0', openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', env('ENCRYPTION_KEY'), 0, $iv);
        return base64_encode($encrypted);
    }

    private function decrypt($data)
    {
        $iv = str_repeat('0', openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted_data = base64_decode($data);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', env('ENCRYPTION_KEY'), 0, $iv);
    }

    public function getAllIndex(array $body, array $header = [])
    {
        return $this->executeWithValidation(
            function() use ($header) {
                $this->validateCustomerKey($header);
                $customer = $this->getCustomerByEncryption($header["customer-key"][0]);
                return $this->getAllIndexData($customer);
            },
            "Proceso ejecutado exitosamente."
        );
    }

    public function getInfraestructureData(array $body, array $header = [])
    {
        return $this->executeWithValidation(
            function() use ($header) {
                $this->validateCustomerKey($header);
                $customer = $this->getCustomerByEncryption($header["customer-key"][0]);
                return $this->getInfraestructureDataArray($customer);
            },
            "Proceso ejecutado exitosamente."
        );
    }

    public function getAplicationData(array $body, array $header = [])
    {
        return $this->executeWithValidation(
            function() use ($header) {
                $this->validateCustomerKey($header);
                $customer = $this->getCustomerByEncryption($header["customer-key"][0]);
                return $this->getAplicationDataArray($customer);
            },
            "Proceso ejecutado exitosamente."
        );
    }

    public function getMyAccountData(array $body, array $header = [])
    {
        return $this->executeWithValidation(
            function() use ($header) {
                $this->validateCustomerKey($header);
                $currentCustomer = $this->getCustomerByEncryption($header["customer-key"][0]);

                return [
                    "id" => $currentCustomer->id,
                    "mail" => $currentCustomer->mail,
                    "first_name" => $currentCustomer->customerAccountInformation->first_name,
                    "last_name" => $currentCustomer->customerAccountInformation->last_name,
                    "phone_number" => $currentCustomer->customerAccountInformation->phone_number,
                    "company" => $currentCustomer->customerAccountInformation->company,
                    "status" => $currentCustomer->status
                ];
            },
            "Proceso ejecutado exitosamente."
        );
    }

    public function getUsersTeamData(array $body, array $header = [])
    {
        return $this->executeWithValidation(
            function() use ($header) {
                $this->validateCustomerKey($header);
                $currentCustomer = $this->getCustomerByEncryption($header["customer-key"][0]);
                $data = [];

                foreach ($currentCustomer->client->allCustomers as $key => $customer) {
                    $data[] = [
                        "id" => $customer->id,
                        "mail" => $customer->mail,
                        "first_name" => $customer->customerAccountInformation->first_name,
                        "last_name" => $customer->customerAccountInformation->last_name,
                        "phone_number" => $customer->customerAccountInformation->phone_number,
                        "company" => $customer->customerAccountInformation->company,
                        "status" => $customer->status
                    ];
                }

                return $data;
            },
            "Proceso ejecutado exitosamente."
        );
    }

    public function getSupportTeamData(array $body, array $header = [])
    {
        return $this->executeWithValidation(
            function() use ($header) {
                $this->validateCustomerKey($header);
                $currentCustomer = $this->getCustomerByEncryption($header["customer-key"][0]);

                return [
                    "access_type" => "",
                    "period" => ""
                ];
            },
            "Proceso ejecutado exitosamente."
        );
    }

    public function getAllIndexData(CustomersAccount $customer)
    {
        $data = [];

        foreach ($customer->client->indexes as $key => $index) {
            $data[] = array(
                "id" => $index->id,
                "code" => $index->code,
                "name" => $index->name
            );
        }

        return $data;
    }

    public function getInfraestructureDataArray(CustomersAccount $customer)
    {
        $data = [];

        foreach ($customer->client->indexes as $key => $index) {
            $data[] = array(
                "code" => $index->code,
                "name" => $index->name,
                "search" => $this->convertNumber(intval($index->recentMonthHistoryQuerySearch()->count() ?? 0)),
                "record" => $this->convertNumber(intval($index->recentMonthHistoryIndex()->sum("count") ?? 0))
            );
        }

        return $data;
    }

    public function getAplicationDataArray(CustomersAccount $customer)
    {
        $data = [];

        $data[] = array(
            "app" => $customer->client->name,
            "code" => $customer->client->code,
            "index" => $customer->client->indexes()->count(),
            "search" => $this->convertNumber(intval($customer->client->recentMonthHistoryQuerySearch()->count() ?? 0)),
            "record" => $this->convertNumber(intval($customer->client->recentMonthHistoryIndex()->sum("count") ?? 0))
        );

        return $data;
    }

    public function getDashboardData(array $body, array $header = [])
    {
        return $this->executeWithValidation(
            function() use ($header) {
                $this->validateCustomerKey($header);
                $customer = $this->getCustomerByEncryption($header["customer-key"][0]);
                return $this->getDataDashboard($customer);
            },
            "Proceso ejecutado exitosamente."
        );
    }

    private function getDataDashboard(CustomersAccount $customer)
    {
        $currentClient = $customer->client;

        return [
            "query" => $this->generateStructureDataBody($currentClient->recentMonthHistoryQuerySearch()),
            "suggestion" => $this->generateStructureSuggestionBody($currentClient->recentMonthHistoryQuerySearchSuggestion()),
            "data" => $this->generateStructureDataIndexes($currentClient)
        ];
    }

    private function generateStructureDataIndexes($currentClient)
    {
        return [
            "index" => $this->getDataIndexDashboard($currentClient),
            "counter" => $this->getCounterDataRecordArray($currentClient->recentMonthHistoryIndex())
        ];
    }

    private function getDataIndexDashboard($currentClient)
    {
        $dataIndex = [];

        foreach ($currentClient->indexes as $index) {
            $dataIndex[] = [
                "code" => $index->code,
                "query" => round($index->recentMonthHistoryQuerySearch()->count()),
                "record" => round($index->recentMonthHistoryIndex()->sum("count"))
            ];
        }

        return $dataIndex;
    }

    private function generateStructureSuggestionBody($collection)
    {
        return ["counter" => $this->getCounterSuggestionDataArray($collection)];
    }

    private function generateStructureDataBody($collection)
    {
        return [
            "counter" => $this->getCounterDataArray($collection),
            "time" => $this->getTimeDataArray($collection)
        ];
    }

    private function generateDateArray()
    {
        $datesArray = [];

        for ($i = 0; $i < 30; $i++) {
            $datesArray[] = Carbon::today()->subDays($i)->toDateString();
        }

        return ["value" => 0, "label" => $datesArray, "data" => []];
    }

    private function getCounterSuggestionDataArray($collection)
    {
        $structure = $this->generateDateArray();

        foreach ($structure["label"] as $date) {
            $newCollection = clone $collection;
            $structure["data"][] = round($newCollection->whereDate("created_at", "=", $date)->count() ?? 0);
        }

        $structure["value"] = $this->convertNumber(array_sum($structure["data"]));
        return $structure;
    }

    private function getCounterDataArray($collection)
    {
        $structure = $this->generateDateArray();

        foreach ($structure["label"] as $date) {
            $newCollection = clone $collection;
            $structure["data"][] = $newCollection->whereDate("created_at", "=", $date)->count() ?? 0;
        }

        $structure["value"] = $this->convertNumber(array_sum($structure["data"]));
        return $structure;
    }

    private function getCounterDataRecordArray($collection)
    {
        $structure = $this->generateDateArray();

        foreach ($structure["label"] as $date) {
            $newCollection = clone $collection;
            $structure["data"][] = round($newCollection->whereDate("created_at", "=", $date)->sum("count") ?? 0);
        }

        $structure["value"] = $this->convertNumber(array_sum($structure["data"]));
        return $structure;
    }

    private function getTimeDataArray($collection)
    {
        $structure = $this->generateDateArray();

        foreach ($structure["label"] as $date) {
            $newCollection = clone $collection;
            $structure["data"][] = round($newCollection->whereDate("created_at", "=", $date)->avg("time_execution") ?? 0);
        }

        $structure["value"] = round(array_sum($structure["data"]) / count($structure["data"]));
        return $structure;
    }

    private function convertNumber($number)
    {
        if ($number < 1000) {
            return $number;
        } elseif ($number < 1000000) {
            return round($number / 1000, 1) . 'K';
        } else {
            return round($number / 1000000, 1) . 'M';
        }
    }
}