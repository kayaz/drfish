<?php

class kCMS_Polish
{
    private $_polish;
    public static function getPolishTranslation()
    {
        $_polish = array("isEmpty" => "Pole nie może być puste",
                        "stringLengthTooShort" => "Minimalna ilość znaków: %min%",
                        "stringLengthTooLong" => "Maksymalna ilość znaków: %max%",
                        "notBetween" => "'%value%' nie zawiera się pomiędzy '%min%' a '%max%'",
                        "notBetweenStrict" => "'%value%' nie zawiera się pomiędzy '%min%' a '%max%'",
                        "emailAddressInvalid" => "Zły adres email",
                        "emailAddressInvalidFormat" => "Zły adres email",
						"emailAddressInvalidHostname" => "Zły adres emailZły adres email",
						"hostnameInvalidHostname" => "'%value%' nie jest poprawnym hostem",
						"hostnameLocalNameNotAllowed" => "'%value%' wydaje sie byc localnym hostem ktory jest zabroniony",
						"stringEmpty" => "'%value%' jest pustą wartością",
                        "notAlnum" => "'%value%' zawiera niedozwolone znaki. Dozwolone są tylko liczby i cyfry.",
                        "invalidLength" => "'%value%' powinien zawierac XX znaków",
                        "regexNotMatch" => "'%value%' nie pasuje do wzorca '%pattern%'",
                        "fileNotExistsDoesExist" => "Brak pliku",
                        "fileUploadErrorNoFile" => "Brak pliku",
                        "fileExtensionFalse" => "Tylko pliki .jpg, .gif, .png",
                        "fileFilesSizeTooBig" => "Max rozmiar pliku to 40kb",
                        "fileImageSizeWidthTooBig" => "Max szerokość to '%maxwidth%'",
                        "fileImageSizeWidthTooSmall" => "Minimalna szerokość to '%minwidth%'",
                        "fileImageSizeHeightTooBig" => "Max wysokość to '%maxheight%'",
                        "fileImageSizeHeightTooSmall" => "Minimalna wysokość to '%minheight%'",
                        "notInt" => "'%value%' nie jest liczbą",
        );
            
        return $_polish;
    }
}
?>