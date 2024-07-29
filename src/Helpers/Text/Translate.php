<?php

namespace Eduard\Account\Helpers\Text;

class Translate
{
    const RESPONSE = "response";
    const RESPONSE_TEXT = "responseText";
    const MAIL_FROM = "From => ";
    const MAIL_REPLY = "Reply-To => ";
    const MAIL_HEADERS = "MIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\n";
    const LINE_LINE = "\r\n";
    const MAIL_CC = "Cc:";
    const DISPLAY_ERROR = "display_errors";
    const AUTHORIZATION = "Authorization";
    const TOKEN_DECLINE = "TOKEN decline.";
    const ACCESS_DECLINE = "Access decline.";
    const CUSTOMER_UUID = "customer-uuid";
    const COLUMN_DOMAIN = "domain";
    const COLUMN_CREATED = "created_at";
    const COLUMN_UPDATED = "updated_at";
    const LONGITUD = "longitud";
    const LONGITUDE = "longitude";
    const LATITUD = "latitud";
    const LATITUDE = "latitude";
    const ADDRESS_EXTRA = "address_extra";
    const ID_MUNICIPALITY = "id_municipality";
    const ID_COUNTRY = "id_country";
    const IDADDRESS_EXTRA = "id_address_extra";
    const ID_LOCALIZATION = "id_localization";
    const LOCALHOST = "127.0.0.1";
    const IP_HOST = "http://ipinfo.io/";
    const BARRA_JSON = "/json";
    const CERO = 0;
    const COMA = ",";
    const ROUNDS = "rounds";
    const EMAIL = "email";
    const USERNAME = "username";
    const PASSWORD = "password";
    const EMAIL_ALREADY = "Email already registered.";
    const CITY = "city";
    const COUNTRY = "country";
    const MUNICIPALITY = "municipality";
    const ENCRYP_METHOD = "sha256";
    const ENCRYP_KEY = "ENCRYPTION_KEY";
    const KEY = "key";
    const QUERY_SUCCESS = "Datos obtenidos exitosamente.";
    const METHOD_POST = "POST";
    const METHOD_GET = "GET";
    const POS_PARAM_ONE = "Content-Type:application/json; charset=utf-8";
    const POS_AUTH = "Authorization: Basic ";
    const ORDER_DESC = "DESC";
    const ORDER_ASC = "ASC";
    const PAIS = "Pais";
    const CIUDAD = "Ciudad";
    const MUNICIPIO = "Municipio";
    const LOCALIZACION = "Localizacion";
    const DIRECCION_EXTRA = "DireccionExtra";
    const IP = "ip";
    const VERSION_VERIFY = "VersionVerify";
    const SPACE_TEXT = " ";
    const ID = "id";
    const TOKEN  = "token";
    const TIME_ZONE = "America/La_Paz";
    const ZONE_FULL_PHP = "Y-m-d H:i:s";
    const DAY_PHP = "d";
    const MONTH_PHP = "m";
    const YEAR_PHP = "Y";
    const DATE_PHP = "Y-m-d";
    const TIME_PHP = "H:i";
    const DATE_TIME_PHP = "H:i:s";
    const CREADO = "Creado";
    const MODIFICADO = "Modificado";
    const CREADO_NOW = "Creado recientemente.";
    const MODIFICADO_NOW = "Modificado recientemente.";
    const HOURS_PHP = "H";
    const MINUTES_PHP = "min";
    const CREATED_DIF = "frecuence_created";
    const UPDATED_DIF = "frecuence_updated";
    const DESCRIPTION = "description";
    const TIME = "time";
    const DAYS_DIFENCENS = " hace % dias.";
    const DAY_DIFENCENS = " hace % dia.";
    const MONTH_DIFENCENS = " hace % mes.";
    const MOTHS_DIFENCENS = " hace % meses.";
    const YEAR_DIFENCENS = " hace % año.";
    const YEARS_DIFENCENS = " hace % años.";
    const QUERY = "query";
    const LIKE = "like";
    const NEGATIVE_ID = "-1";
    const DISTINCT_SYMBOL = "!=";
    const PERCENT = "%";
    const COLUMN_NAME = "name";
    const COLUMN_ID_CITY = "id_city";
    const MESSAGES_LOGN = [
        "Bienvenido.",
        "Contraseña erronea.",
        "La cuenta se encuentra desactivada.",
        "El usuario no se encuentra registrado.",
        "El partner ingresado no existe.",
        "Formato invalido de usuario.",
        "La cuenta no existe.",
        "La cuenta de su negocio se encuentra bloqueada por favor contactarse con nosotros."
    ];
    const TEXT = "text";
    const STATUS = "status";
    const ID_ACCOUNT = "id_account";
    const ARROBA = "@";
    const PARTNER_ALREADY = "Partner already registered.";
    const PARTNER_REGISTER = "La cuenta ya se encuentra registrada.";
    const ID_PARTNER = "id_partner";
    const ADD_SUCCESS = "Registro exitoso.";
    const ACCOUNT_RESPONSE = "Cuenta obtenida exitosamente.";
    const ERROR_QUERY = "Ocurrio un error al realizar la acción.";
    const SUCCESS_QUERY = "Accion realizada exitosamente.";

    public function __construct()
    {
        //
    }

    /**
     * @return string
     */
    public function getErrorQuery()
    {
        return self::ERROR_QUERY;
    }

    /**
     * @return string
     */
    public function getSuccessQuery()
    {
        return self::SUCCESS_QUERY;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return self::TOKEN;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return self::ID;
    }

    /**
     * @return string
     */
    public function getSpace()
    {
        return self::SPACE_TEXT;
    }

    /**
     * @return string
     */
    public function getVersionVerify()
    {
        return self::VERSION_VERIFY;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return self::IP;
    }

    /**
     * @return string
     */
    public function getDireccionExtra()
    {
        return self::DIRECCION_EXTRA;
    }

    /**
     * @return string
     */
    public function getLocalizacion()
    {
        return self::LOCALIZACION;
    }

    /**
     * @return string
     */
    public function getMunicipio()
    {
        return self::MUNICIPIO;
    }

    /**
     * @return string
     */
    public function getCiudad()
    {
        return self::CIUDAD;
    }

    /**
     * @return string
     */
    public function getPais()
    {
        return self::PAIS;
    }

    /**
     * @return string
     */
    public function getOrderDesc()
    {
        return self::ORDER_DESC;
    }

    /**
     * @return string
     */
    public function getOrderAsc()
    {
        return self::ORDER_ASC;
    }

    /**
     * @return string
     */
    public function getPosAuth()
    {
        return self::POS_AUTH;
    }

    /**
     * @return string
     */
    public function getPosParamOne()
    {
        return self::POS_PARAM_ONE;
    }

    /**
     * @return string
     */
    public function getMethodPost()
    {
        return self::METHOD_POST;
    }

    /**
     * @return string
     */
    public function getMethodGet()
    {
        return self::METHOD_GET;
    }

    /**
     * @return string
     */
    public function getQuerySuccess()
    {
        return self::QUERY_SUCCESS;
    }

    /**
     * @param bool|array|null|int|string|float $status
     * @param string $response
     * @return array
     */
    public function getResponseApi(bool|array|null|int|string|float $status, string $response)
    {
        return array(
            self::RESPONSE => $status,
            self::RESPONSE_TEXT => $response
        );
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return self::KEY;
    }

    /**
     * @return string
     */
    public function getEncryptMethod()
    {
        return self::ENCRYP_METHOD;
    }

    /**
     * @return string
     */
    public function getEncryptKey()
    {
        return self::ENCRYP_KEY;
    }

    /**
     * @return string
     */
    public function getMunicipality()
    {
        return self::MUNICIPALITY;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return self::COUNTRY;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return self::CITY;
    }

    /**
     * @return string
     */
    public function getEmailAlready()
    {
        return self::EMAIL_ALREADY;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return self::USERNAME;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return self::PASSWORD;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return self::EMAIL;
    }

    /**
     * @return string
     */
    public function getRounds()
    {
        return self::ROUNDS;
    }

    /**
     * @return string
     */
    public function getCero()
    {
        return self::CERO;
    }

    /**
     * @return string
     */
    public function getComa()
    {
        return self::COMA;
    }

    /**
     * @return string
     */
    public function getBarraJson()
    {
        return self::BARRA_JSON;
    }

    /**
     * @return string
     */
    public function getLocalhost()
    {
        return self::LOCALHOST;
    }

    /**
     * @return string
     */
    public function getIpHost()
    {
        return self::IP_HOST;
    }

    /**
     * @return string
     */
    public function getIdLocalization()
    {
        return self::ID_LOCALIZATION;
    }

    /**
     * @return string
     */
    public function getIdAddressExtra()
    {
        return self::IDADDRESS_EXTRA;
    }

    /**
     * @return string
     */
    public function getAddressExtra()
    {
        return self::ADDRESS_EXTRA;
    }

    /**
     * @return string
     */
    public function getIdMunicipality()
    {
        return self::ID_MUNICIPALITY;
    }

    /**
     * @return string
     */
    public function getIdCountry()
    {
        return self::ID_COUNTRY;
    }

    /**
     * @return string
     */
    public function getLongitud()
    {
        return self::LONGITUD;
    }

    /**
     * @return string
     */
    public function getLongitude()
    {
        return self::LONGITUDE;
    }

    /**
     * @return string
     */
    public function getLatitud()
    {
        return self::LATITUD;
    }

    /**
     * @return string
     */
    public function getLatitude()
    {
        return self::LATITUDE;
    }

    /**
     * @return string
     */
    public function getUpdated()
    {
        return self::COLUMN_UPDATED;
    }

    /**
     * @return string
     */
    public function getCreated()
    {
        return self::COLUMN_CREATED;
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return self::COLUMN_DOMAIN;
    }

    /**
     * @return string
     */
    public function getAccessDecline()
    {
        return self::ACCESS_DECLINE;
    }

    /**
     * @return string
     */
    public function getCustomerUuid()
    {
        return self::CUSTOMER_UUID;
    }

    /**
     * @return string
     */
    public function getTokenDecline()
    {
        return self::TOKEN_DECLINE;
    }

    /**
     * @return string
     */
    public function getAuthorization()
    {
        return self::AUTHORIZATION;
    }

    /**
     * @return string
     */
    public function getDisplayError()
    {
        return self::DISPLAY_ERROR;
    }

    /**
     * @return string
     */
    public function getMailCc()
    {
        return self::MAIL_CC;
    }

    /**
     * @return string
     */
    public function getLine()
    {
        return self::LINE_LINE;
    }

    /**
     * @return string
     */
    public function getMailFrom()
    {
        return self::MAIL_FROM;
    }

    /**
     * @return string
     */
    public function getMailReply()
    {
        return self::MAIL_REPLY;
    }

    /**
     * @return string
     */
    public function getMailHeaders()
    {
        return self::MAIL_HEADERS;
    }

    /**
     * @return string
     */
    public function getHoursPhp()
    {
        return self::HOURS_PHP;
    }

    /**
     * @return string
     */
    public function getMinutesPhp()
    {
        return self::MINUTES_PHP;
    }

    /**
     * @return string
     */
    public function getCreadoNow()
    {
        return self::CREADO_NOW;
    }

    /**
     * @return string
     */
    public function getModificadoNow()
    {
        return self::MODIFICADO_NOW;
    }

    /**
     * @return string
     */
    public function getModificado()
    {
        return self::MODIFICADO;
    }

    /**
     * @return string
     */
    public function getCreado()
    {
        return self::CREADO;
    }

    /**
     * @return string
     */
    public function getTimePhp()
    {
        return self::TIME_PHP;
    }

    /**
     * @return string
     */
    public function getDateTimePhp()
    {
        return self::DATE_TIME_PHP;
    }

    /**
     * @return string
     */
    public function getDatePhp()
    {
        return self::DATE_PHP;
    }

    /**
     * @return string
     */
    public function getDayPhp()
    {
        return self::DAY_PHP;
    }

    /**
     * @return string
     */
    public function getMonthPhp()
    {
        return self::MONTH_PHP;
    }

    /**
     * @return string
     */
    public function getYearPhp()
    {
        return self::YEAR_PHP;
    }

    /**
     * @return string
     */
    public function getZoneFull()
    {
        return self::ZONE_FULL_PHP;
    }

    /**
     * @return string
     */
    public function getTimeZone()
    {
        return self::TIME_ZONE;
    }

    /**
     * @param string|int $number
     * @param string $label
     * @return string
     */
    public function concatTwoString(string|int $number, string $label)
    {
        return $number . " " . $label;
    }

    /**
     * @return string
     */
    public function getCreatedDiference()
    {
        return self::CREATED_DIF;
    }

    /**
     * @return string
     */
    public function getUpdatedDiference()
    {
        return self::UPDATED_DIF;
    }

    /**
     * @param string $text
     * @param int $days
     * @return string
     */
    public function getDiferenceDays(string $text, int $days)
    {
        return $text . str_replace($this->getPercent(), $days, $days > 1 ? self::DAYS_DIFENCENS : self::DAY_DIFENCENS);
    }

    /**
     * @return string
     */
    public function getPercent()
    {
        return self::PERCENT;
    }

    /**
     * @return string
     */
    public function getLike()
    {
        return self::LIKE;
    }

    /**
     * @param string $text
     * @param int $month
     * @return string
     */
    public function getDiferenceMonth(string $text, int $month)
    {
        return $text . str_replace($this->getPercent(), $month, $month > 1 ? self::MOTHS_DIFENCENS : self::MONTH_DIFENCENS);
    }

    /**
     * @param string $text
     * @param int $year
     * @return string
     */
    public function getDiferenceYear(string $text, int $year)
    {
        return $text . str_replace($this->getPercent(), $year, $year > 1 ? self::YEARS_DIFENCENS : self::YEAR_DIFENCENS);
    }

    /**
     * @return string
     */
    public function getIdCity()
    {
        return self::COLUMN_ID_CITY;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return self::COLUMN_NAME;
    }

    /**
     * @param bool $status
     * @param int $position
     * @param string|null $token
     * @return array
     */
    public function messageLogin(bool $status, int $position, string|null $token = null)
    {
        return array(
            $this->getStatus() => $status,
            $this->getText() => self::MESSAGES_LOGN[$position],
            $this->getToken() => $token
        );
    }

    /**
     * @return string
     */
    public function getText()
    {
        return self::TEXT;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return self::STATUS;
    }

    /**
     * @return string
     */
    public function getIdAccount()
    {
        return self::ID_ACCOUNT;
    }

    /**
     * @return string
     */
    public function getArroba()
    {
        return self::ARROBA;
    }

    /**
     * @return string
     */
    public function getPartnerAlready()
    {
        return self::PARTNER_ALREADY;
    }

    /**
     * @param string $texto
     * @return string
     */
    function camelCase(string $texto)
    {
        $palabras = preg_split('/[\s_]+/', $texto);
        $palabras = array_map('ucfirst', $palabras);
        $camelCase = implode('', $palabras);
        return $camelCase;
    }

    /**
     * @param string $texto
     * @return string
     */
    function snakeCase(string $texto)
    {
        $texto = str_replace(' ', '_', $texto);
        $snakeCase = preg_replace('/[\s_]+/', '_', $texto);
        $snakeCase = strtolower($snakeCase);
        return $snakeCase;
    }

    /**
     * @return string
     */
    public function getAccountRegister()
    {
        return self::PARTNER_REGISTER;
    }

    /**
     * @return string
     */
    public function getIdPartner()
    {
        return self::ID_PARTNER;
    }

    /**
     * @return string
     */
    public function getAddSuccess()
    {
        return self::ADD_SUCCESS;
    }

    /**
     * @return string
     */
    public function getAccountResponse(){
        return self::ACCOUNT_RESPONSE;
    }

    
    /**
     * @return string
     */
    public function getAccountNoExist()
    {
        return self::MESSAGES_LOGN[6];
    }
}
