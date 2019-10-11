<?php

namespace Acme;

final class Parser
{
    /**
     * @param string $email
     * @return string
     */
    public static function formatEmail(string $email): string
    {
        $result = explode("-", $email, 2);
        return (count($result) > 1) ? $result[1] : $result[0];
    }

    /**
     * @param string $matchKey
     * @return string
     */
    public static function hashMatchKey(string $matchKey): string
    {
        return hash("sha256", $matchKey);
    }

    /**
     * @param string $event_time
     * @return false|int
     */
    public static function dateToTimestamp(string $event_time)
    {
        return strtotime($event_time);
    }
}
