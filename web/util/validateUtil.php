<?php
function isEmailValido($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}