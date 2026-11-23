<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

class HtmlBersih
{
    private const TAG_BOLEH = [
        'p', 'br', 'strong', 'b', 'em', 'i', 'u', 's',
        'h1', 'h2', 'h3', 'h4', 'ul', 'ol', 'li',
        'blockquote', 'a', 'img', 'span', 'pre', 'hr',
    ];

    private const TAG_BUANG = [
        'script', 'style', 'iframe', 'object', 'embed',
        'form', 'input', 'button', 'svg', 'math',
    ];

    public static function bersihkan(?string $html): string
    {
        if ($html === null || trim($html) === '') {
            return '';
        }

        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(
            '<?xml encoding="utf-8" ?><div>' . $html . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();

        $root = $dom->getElementsByTagName('div')->item(0);
        if (! $root) {
            return '';
        }

        self::telusuri($root);

        $hasil = '';
        foreach ($root->childNodes as $anak) {
            $hasil .= $dom->saveHTML($anak);
        }

        return trim($hasil);
    }

    private static function telusuri(DOMNode $induk): void
    {
        foreach (iterator_to_array($induk->childNodes) as $anak) {
            if ($anak->nodeType === XML_COMMENT_NODE) {
                $induk->removeChild($anak);
                continue;
            }

            if (! $anak instanceof DOMElement) {
                continue;
            }

            $tag = strtolower($anak->tagName);

            if (in_array($tag, self::TAG_BUANG, true)) {
                $induk->removeChild($anak);
                continue;
            }

            self::telusuri($anak);

            if (! in_array($tag, self::TAG_BOLEH, true)) {
                while ($anak->firstChild) {
                    $induk->insertBefore($anak->firstChild, $anak);
                }
                $induk->removeChild($anak);
                continue;
            }

            self::bersihkanAtribut($anak, $tag);
        }
    }

    private static function bersihkanAtribut(DOMElement $el, string $tag): void
    {
        foreach (iterator_to_array($el->attributes) as $attr) {
            $nama = strtolower($attr->name);
            $nilai = trim($attr->value);
            $boleh = false;

            if ($nama === 'class') {
                $kelas = array_filter(
                    explode(' ', $nilai),
                    fn ($k) => str_starts_with($k, 'ql-')
                );
                if ($kelas) {
                    $el->setAttribute('class', implode(' ', $kelas));
                    $boleh = true;
                }
            } elseif ($tag === 'a' && $nama === 'href') {
                $boleh = (bool) preg_match('#^(https?://|mailto:)#i', $nilai);
            } elseif ($tag === 'img' && $nama === 'src') {
                $boleh = (bool) preg_match('#^(https?://|/storage/)#i', $nilai);
            } elseif ($tag === 'img' && $nama === 'alt') {
                $boleh = true;
            }

            if (! $boleh) {
                $el->removeAttribute($attr->name);
            }
        }

        if ($tag === 'a') {
            $el->setAttribute('target', '_blank');
            $el->setAttribute('rel', 'noopener noreferrer');
        }
    }
}

