<?php
/** BAD ENG
 * @param $emails as array
 * @param array $blacklistDomains (optional)
 * @return array
 *
 * this function (method) filter an email list array
 * its remove duplicates and trim the emails (remove last space \r or last enters \n) and make sure this is a valid Email 
 * also make all character in lowercase
 */
 
function emails_filter($emails, $blacklistDomains = []){
    if (!is_array($emails)){
        $emails = [$emails];
    }


    if (empty($blacklistDomains)) {
        $blacklistDomains = [
                'yahoo-inc.com', 'facebook.com',
                'emailna.co', 'mozej.com', 'emailo.pro', 'mailna.biz', 'mailna.co', 'mailna.in', 'mailna.me', 'mohmal.in',
                'emailtown.club', 'emailmonkey.club',
                'lms.com', 'g.mail.com',
            ];
    }

    $emails = array_map(function ($email){
        return strtolower(trim($email));
    },$emails);


    $emails = array_filter($emails, function($email) use ($blacklistDomains) {
        $domain = explode("@", $email);
        $domain = $domain[(count($domain)-1)];
//        if (!in_array($domain, $blacklistDomains) && checkdnsrr($domain,'MX')) {
        if (!in_array($domain, $blacklistDomains)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            }
        }
    });

    $emails = array_values(array_unique($emails));
    return $emails;
}
