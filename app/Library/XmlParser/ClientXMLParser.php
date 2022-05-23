<?php

namespace App\Library\XmlParser;

class ClientXMLParser extends AbstructXMLParserClass
{
    public function parseYml_Catalog()
    {
        if ($this->reader->nodeType == \XMLREADER::ELEMENT && $this->reader->localName == 'yml_catalog') {
            $date = (string)$this->reader->getAttribute('date');
            return $date;
        }
        return false;
    }

    public function parseCategory()
    {
        if ($this->reader->nodeType == \XMLREADER::ELEMENT && $this->reader->localName == 'category') {

            $category = array(
                'id' => $this->reader->getAttribute('id'),
                'parentId' => $this->reader->getAttribute('parentId')
            );
            $this->reader->read();
            if ($this->reader->nodeType == \XMLREADER::TEXT)
                $category['title'] = $this->reader->value;

            return $category;
        }
        return false;
    }

    public function parseOffer()
    {
        if ($this->reader->nodeType == \XMLREADER::ELEMENT && $this->reader->localName == 'offer') {

            $offer = array(
                'id' => (int)$this->reader->getAttribute('id'),
                'available' => (int)($this->reader->getAttribute('available') == true ? 1 : 0)
            );

            $offer_attrs = ['url', 'price', 'currencyId', 'categoryId', 'market_category', 'barcode', 'store', 'pickup', 'model', 'typePrefix', 'vendor', 'description', 'vendorCode', 'delivery', 'sales_notes'];
            $boolean_attrs = ['store', 'pickup', 'delivery'];

            while (1) {
                $this->reader->read();
                if ($this->reader->nodeType == \XMLREADER::ELEMENT && in_array($this->reader->localName, $offer_attrs)) {
                    $localname = $this->reader->localName;
                    while (true) {
                        $this->reader->read();
                        if ($this->reader->nodeType == \XMLREADER::TEXT) {
                            $value = $this->reader->value;
                            if (in_array($localname, $boolean_attrs)) {
                                if ($value == true || $value == "true") {
                                    $value = 1;
                                } elseif ($value == false || $value == "false") {
                                    $value = 0;
                                }
                            }
                            $offer[$localname] = $value;
                            break;
                        }
                        if ($this->reader->nodeType == \XMLREADER::END_ELEMENT) {
                            break;
                        }
                    }
                }

                // offer.pictures

                if ($this->reader->nodeType == \XMLREADER::ELEMENT && $this->reader->localName == "picture") {
                    if (!isset($offer['pictures'])) {
                        $offer['pictures'] = [];
                    }
                    while (true) {
                        $this->reader->read();
                        if ($this->reader->nodeType == \XMLREADER::TEXT) {
                            $offer['pictures'][] = $this->reader->value;
                            break;
                        }
                        if ($this->reader->nodeType == \XMLREADER::END_ELEMENT) {
                            break;
                        }
                    }
                }

                // offer.params

                if ($this->reader->nodeType == \XMLREADER::ELEMENT && $this->reader->localName == "param") {
                    if (!isset($offer['params'])) {
                        $offer['params'] = [];
                    }
                    $name = $this->reader->getAttribute('name');
                    while (true) {
                        $this->reader->read();
                        if ($this->reader->nodeType == \XMLREADER::TEXT) {
                            $offer['params'][$name] = $this->reader->value;
                            break;
                        }
                        if ($this->reader->nodeType == \XMLREADER::END_ELEMENT) {
                            break;
                        }
                    }
                }

                // offer.delivery-options

                if ($this->reader->nodeType == \XMLREADER::ELEMENT && $this->reader->localName == "delivery-options") {
                    if (!isset($offer['delivery-options'])) {
                        $offer['delivery-options'] = [];
                    }
                    $name = $this->reader->getAttribute('name');
                    while (true) {
                        $this->reader->read();
                        if ($this->reader->nodeType == \XMLREADER::ELEMENT && $this->reader->name == "option") {
                            $offer['delivery-options'][] = [
                                'days' => $this->reader->getAttribute('days'),
                                'cost' => $this->reader->getAttribute('cost')
                            ];
                            break;
                        }
                        if ($this->reader->nodeType == \XMLREADER::END_ELEMENT && $this->reader->name == "delivery-options") {
                            break;
                        }
                    }
                }

                if ($this->reader->nodeType == \XMLREADER::END_ELEMENT && $this->reader->name == "offer") {
                    break;
                }
            }

            return $offer;
        }
    }
}
