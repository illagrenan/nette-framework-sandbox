<?php

class TimeAgo extends Nette\Object
{

    public static
            function inWords($delta)
    {

        if ($delta >= 0)
        {
            if ($delta == 0)
                return 'now';
            if ($delta == 1)
                return 'in 1 second';
            if ($delta < 60)
                return 'in ' . $delta . ' ' . self::plural($delta, 'second', 'seconds', 'seconds');

            $delta = round(abs($delta) / 60);

            if ($delta == 1)
                return 'in 1 minute';
            if ($delta < 45)
                return 'in ' . $delta . ' ' . self::plural($delta, 'minute', 'minutes', 'minutes');
            if ($delta < 90)
                return 'in 1 hour';
            if ($delta < 1440)
                return 'in ' . round($delta / 60) . ' ' . self::plural(round($delta / 60), 'hour', 'hours', 'hours');
            /* if ($delta < 2880) return 'z�tra';
              if ($delta < 43200) return 'za ' . round($delta / 1440) . ' ' . self::plural(round($delta / 1440), 'den', 'dny', 'dn�');
              if ($delta < 86400) return 'za m�s�c';
              if ($delta < 525960) return 'za ' . round($delta / 43200) . ' ' . self::plural(round($delta / 43200), 'm�s�c', 'm�s�ce', 'm�s�c�');
              if ($delta < 1051920) return 'za rok';
              return 'za ' . round($delta / 525960) . ' ' . self::plural(round($delta / 525960), 'rok', 'roky', 'let'); */
        }else
        {
            return "now";
        }
    }

    /**
     * Plural: three forms, special cases for 1 and 2, 3, 4.
     * (Slavic family: Slovak, Czech)
     * @param  int
     * @return mixed
     */
    private static
            function plural($n)
    {
        $args = func_get_args();
        return $args[($n == 1) ? 1 : (($n >= 2 && $n <= 4) ? 2 : 3)];
    }

}