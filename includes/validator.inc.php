<?php
        Class validator {
            //validatorklasse for å validere eposter, passord og telefonnummer
            public static function validate($input, $type) {
                $input = trim(htmlspecialchars(($input)));
            
                switch ($type) {
                    case 'email':
                        if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                            return false;
                        }
                        break;
                        case 'passord':
                            if (!preg_match('/^(?=.*[A-Z])(?=.*\d{2,})(?=.*[\W_])[a-zA-Z\d\W_]{9,}$/', $input)) {
                                return false;
                            }
                            break;
                    case 'tlf':
                        if (!preg_match('/^(\+47|0047|47)?\d{8}$/', $input)) {
                            return false;
                        }
                        break;

                    case 'navn':
                        if (!preg_match('/^[a-zA-ZæøåÆØÅ\s-]{2,50}$/', $input)) {
                            return false;
                        }
                        break;
                    default:
                        return false;
                }
                //returnerer true hvis inputen er gyldig
                return true;
            }

            public static function validate_room_attributes ($input, $type) {
                $input = trim(htmlspecialchars($input));
                switch ($type) {
                    case 'roomType':
                        if (!preg_match('/^[a-zA-ZæøåÆØÅ\s-]{2,50}$/', $input)) {
                            echo '<p style="color: red;">Invalid room type description, no changes made.</p>';
                            return false;
                        }
                        break;
                    case 'nrAdults':
                        if (!preg_match('/^[1-8]{1}$/', $input)) {
                            echo '<p style="color: red;">Invalid number of adults, no changes made.</p>';
                            return false;
                        }
                        break;
                    case 'nrChildren':
                        if (!preg_match('/^[0-9]{1}$/', $input)) {
                            echo '<p style="color: red;">Invalid number of children, no changes made.</p>';
                            return false;
                        }
                        break;
                    case 'description':
                        if (!preg_match('/^[a-zA-ZæøåÆØÅ\s-]{2,50}$/', $input)) {
                            echo '<p style="color: red;">Invalid room description, no changes made.</p>';
                            return false;
                        }
                        break;
                    case 'price':
                        if (!preg_match('/^[0-9]{1,5}$/', $input)) {
                            echo '<p style="color: red;">Invalid price, no changes made.</p>';
                            return false;
                        }
                        break;
                    default:
                        return false;
                }
                return true;
            }

            public static function sanitise($input) {
                return trim(htmlspecialchars($input));
            }
        }