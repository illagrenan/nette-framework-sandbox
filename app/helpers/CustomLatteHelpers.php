<?php

namespace CustomLatteHelpers;

use Nette\Object;
use ObjednavkovyIS\Order;
use Nette\Utils\Html;

class Helpers extends Object
{

    /** @var string */
    private $wwwDir;

    /** @var \Nette\Http\IRequest */
    private $httpRequest;

    public function __construct($wwwDir, \Nette\Http\Request $httpRequest)
    {
        $this->wwwDir = $wwwDir;
        $this->httpRequest = $httpRequest;
    }

    /**
     * Metoda, kterou zaregistrujeme jako callback
     * v metodě $template->registerHelperLoader().
     */
    public function loader($helper)
    {
        if (method_exists($this, $helper))
        {
            return callback($this, $helper);
        }
    }

    /* === Následují jednotlivé helpery === */

    /**
     * Zobrazení naformátovaného stavu objednávky
     *
     * <code>
     * Stav objednávky: {'Zpracovává se'|orderState}
     * </code>
     *
     * @param  string stav objednávky
     * @return string html element s barevnou reprezentací stavu objednávky
     * @throws \InvalidArgumentException
     */
    public function orderState($orderState)
    {
        // $basePath = $this->httpRequest->url->scriptPath;

        /* @var $newFormattedState Html */
        $newFormattedState = Html::el("span")->class("label")->setText($orderState);

        switch ($orderState)
        {
            // stavy polozek
            case \ObjednavkovyIS\Item::STAV_NOVA:
                $newFormattedState->addClass("label-info");
                break;

            case \ObjednavkovyIS\Item::STAV_HOTOVA:
                $newFormattedState->addClass("label-success");
                break;

            // stavy objednavky podle položek
            case Order::STAV_POLOZEK_CEKA_NA_NASKLEDNENI:
                $newFormattedState->addClass("label-info");
                break;

            case Order::STAV_POLOZEK_NASKLADNENO:
                $newFormattedState->addClass("label-success");
                break;

            // stav objednávky
            case \ObjednavkovyIS\OrderChoices\State::STAV_NEVYRIZENO:
                $newFormattedState->addClass("label-info");
                break;

            case \ObjednavkovyIS\OrderChoices\State::STAV_EXPEDOVANO_POSTOU:
                $newFormattedState->addClass("label-info");
                break;

            case \ObjednavkovyIS\OrderChoices\State::STAV_PRIPRAVENO_K_MONTAZI:
                $newFormattedState->addClass("label-info");
                break;

            case \ObjednavkovyIS\OrderChoices\State::STAV_PRIPRAVENO_K_OSOBNIMU_ODBERU:
                $newFormattedState->addClass("label-info");
                break;

            case \ObjednavkovyIS\OrderChoices\State::STAV_PRIPRAVENO_K_VYZVEDNUTI_OBCHODNIM_ZASTUPCEM:
                $newFormattedState->addClass("label-info");
                break;

            case \ObjednavkovyIS\OrderChoices\State::STAV_VYRIZENO:
                $newFormattedState->addClass("label-success");
                break;

            case \ObjednavkovyIS\OrderChoices\State::STAV_ZAMITNUTA:
                $newFormattedState->addClass("label-important");
                break;

            // Přidáno kvůli posledním úpravám ve stavech objednávky, aby to zbytečně nepadalo
            case "":
                $newFormattedState->setText("Neznámý stav");
                $newFormattedState->addClass("label-inverse");
                break;

            default:
                throw new \InvalidArgumentException("Given order state '" . $orderState . "' is not valid or is unknown. Each order must have a state (check database).");
        }

        return $newFormattedState;
    }

    public static function currency($value)
    {
        return str_replace(" ", "\xc2\xa0", number_format($value, 0, "", " ")) . "\xc2\xa0Kč";
    }

    /**
     * Zobrazení hodnot Ano/Ne nebo vlastních hodnot místo true/false.
     * @param boolean $booleanValue rozhodovací hodnota
     * @param string $trueOption
     * @param string $falseOption
     * @return string text trueOption nebo falseOption
     */
    public function formatBoolean($booleanValue, $trueOption = 'Ano', $falseOption = 'Ne')
    {
        if ($booleanValue)
        {
            return $trueOption;
        } else
        {
            return $falseOption;
        }
    }

}