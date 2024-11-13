<?php
        Class validator {
            //validatorklasse for å validere eposter, passord og telefonnummer
            public static function validate($input, $type) {
                $input = trim(htmlspecialchars(($input)));
            
                switch ($type) {
                    case 'email':
                        if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                            echo "<p class = 'error'>" . "vennligst skriv inn eposten i riktig format";
                            return false;
                        }
                        break;
                        case 'passord':
                            if (!preg_match('/^(?=.*[A-Z])(?=.*\d{2,})(?=.*[\W_])[a-zA-Z\d\W_]{9,}$/', $input)) {
                                echo "<p class = 'error'>" . "vennligst skriv inn et gyldig passord bestående av minst 9 tegn, 2 tall, 1 stor bokstav og 1 spesialtegn";
                                return false;
                            }
                            break;
                    case 'tlf':
                        if (!preg_match('/^(\+47|0047|47)?\d{8}$/', $input)) {
                            echo "<p class = 'error'>" . "vennligst skriv inn nummeret i riktig format, 8 tall";
                            return false;
                        }
                        break;
                    default:
                        return false;
                }
                //returnerer true hvis inputen er gyldig
                return true;
            }

            public static function sanitise($input) {
                return trim(htmlspecialchars($input));
            }
        }