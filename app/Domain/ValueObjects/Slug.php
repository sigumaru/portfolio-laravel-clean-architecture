<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class Slug
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty(trim($value))) {
            throw new InvalidArgumentException('Slug cannot be empty');
        }

        $this->value = $this->normalize($value);
    }

    public static function fromTitle(string $title): self
    {
        return new self($title);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(Slug $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function normalize(string $value): string
    {
        // まず前後の空白を削除
        $slug = trim($value);

        // 日本語ひらがな・カタカナをローマ字に変換
        $slug = $this->romanize($slug);

        // 小文字に変換
        $slug = mb_strtolower($slug, 'UTF-8');

        // 特殊記号（句読点、記号）をハイフンに変換
        $slug = preg_replace('/[\s\p{P}\p{S}]+/u', '-', $slug);

        // ASCIIへの変換を試みる（アクセント付き文字などを変換）
        $transliterated = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $slug);
        if ($transliterated !== false && trim($transliterated) !== '') {
            $slug = $transliterated;
        }

        // ASCII文字、数字、ハイフン以外を削除
        $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);

        // 連続するハイフンを1つに
        $slug = preg_replace('/-+/', '-', $slug);

        // 前後のハイフンを削除
        $slug = trim($slug, '-');

        // 空の場合はランダムな文字列を生成
        if ($slug === '') {
            $slug = strtolower(bin2hex(random_bytes(6)));
        }

        return $slug;
    }

    /**
     * 日本語（ひらがな・カタカナ）をローマ字に変換
     */
    private function romanize(string $text): string
    {
        $hiraganaMap = [
            'きゃ' => 'kya', 'きゅ' => 'kyu', 'きょ' => 'kyo',
            'しゃ' => 'sha', 'しゅ' => 'shu', 'しょ' => 'sho',
            'ちゃ' => 'cha', 'ちゅ' => 'chu', 'ちょ' => 'cho',
            'にゃ' => 'nya', 'にゅ' => 'nyu', 'にょ' => 'nyo',
            'ひゃ' => 'hya', 'ひゅ' => 'hyu', 'ひょ' => 'hyo',
            'みゃ' => 'mya', 'みゅ' => 'myu', 'みょ' => 'myo',
            'りゃ' => 'rya', 'りゅ' => 'ryu', 'りょ' => 'ryo',
            'ぎゃ' => 'gya', 'ぎゅ' => 'gyu', 'ぎょ' => 'gyo',
            'じゃ' => 'ja', 'じゅ' => 'ju', 'じょ' => 'jo',
            'びゃ' => 'bya', 'びゅ' => 'byu', 'びょ' => 'byo',
            'ぴゃ' => 'pya', 'ぴゅ' => 'pyu', 'ぴょ' => 'pyo',
            'あ' => 'a', 'い' => 'i', 'う' => 'u', 'え' => 'e', 'お' => 'o',
            'か' => 'ka', 'き' => 'ki', 'く' => 'ku', 'け' => 'ke', 'こ' => 'ko',
            'が' => 'ga', 'ぎ' => 'gi', 'ぐ' => 'gu', 'げ' => 'ge', 'ご' => 'go',
            'さ' => 'sa', 'し' => 'shi', 'す' => 'su', 'せ' => 'se', 'そ' => 'so',
            'ざ' => 'za', 'じ' => 'ji', 'ず' => 'zu', 'ぜ' => 'ze', 'ぞ' => 'zo',
            'た' => 'ta', 'ち' => 'chi', 'つ' => 'tsu', 'て' => 'te', 'と' => 'to',
            'だ' => 'da', 'ぢ' => 'ji', 'づ' => 'zu', 'で' => 'de', 'ど' => 'do',
            'な' => 'na', 'に' => 'ni', 'ぬ' => 'nu', 'ね' => 'ne', 'の' => 'no',
            'は' => 'ha', 'ひ' => 'hi', 'ふ' => 'fu', 'へ' => 'he', 'ほ' => 'ho',
            'ば' => 'ba', 'び' => 'bi', 'ぶ' => 'bu', 'べ' => 'be', 'ぼ' => 'bo',
            'ぱ' => 'pa', 'ぴ' => 'pi', 'ぷ' => 'pu', 'ぺ' => 'pe', 'ぽ' => 'po',
            'ま' => 'ma', 'み' => 'mi', 'む' => 'mu', 'め' => 'me', 'も' => 'mo',
            'や' => 'ya', 'ゆ' => 'yu', 'よ' => 'yo',
            'ら' => 'ra', 'り' => 'ri', 'る' => 'ru', 'れ' => 're', 'ろ' => 'ro',
            'わ' => 'wa', 'を' => 'wo', 'ん' => 'n',
        ];

        $katakanaMap = [
            'キャ' => 'kya', 'キュ' => 'kyu', 'キョ' => 'kyo',
            'シャ' => 'sha', 'シュ' => 'shu', 'ショ' => 'sho',
            'チャ' => 'cha', 'チュ' => 'chu', 'チョ' => 'cho',
            'ニャ' => 'nya', 'ニュ' => 'nyu', 'ニョ' => 'nyo',
            'ヒャ' => 'hya', 'ヒュ' => 'hyu', 'ヒョ' => 'hyo',
            'ミャ' => 'mya', 'ミュ' => 'myu', 'ミョ' => 'myo',
            'リャ' => 'rya', 'リュ' => 'ryu', 'リョ' => 'ryo',
            'ギャ' => 'gya', 'ギュ' => 'gyu', 'ギョ' => 'gyo',
            'ジャ' => 'ja', 'ジュ' => 'ju', 'ジョ' => 'jo',
            'ビャ' => 'bya', 'ビュ' => 'byu', 'ビョ' => 'byo',
            'ピャ' => 'pya', 'ピュ' => 'pyu', 'ピョ' => 'pyo',
            'ア' => 'a', 'イ' => 'i', 'ウ' => 'u', 'エ' => 'e', 'オ' => 'o',
            'カ' => 'ka', 'キ' => 'ki', 'ク' => 'ku', 'ケ' => 'ke', 'コ' => 'ko',
            'ガ' => 'ga', 'ギ' => 'gi', 'グ' => 'gu', 'ゲ' => 'ge', 'ゴ' => 'go',
            'サ' => 'sa', 'シ' => 'shi', 'ス' => 'su', 'セ' => 'se', 'ソ' => 'so',
            'ザ' => 'za', 'ジ' => 'ji', 'ズ' => 'zu', 'ゼ' => 'ze', 'ゾ' => 'zo',
            'タ' => 'ta', 'チ' => 'chi', 'ツ' => 'tsu', 'テ' => 'te', 'ト' => 'to',
            'ダ' => 'da', 'ヂ' => 'ji', 'ヅ' => 'zu', 'デ' => 'de', 'ド' => 'do',
            'ナ' => 'na', 'ニ' => 'ni', 'ヌ' => 'nu', 'ネ' => 'ne', 'ノ' => 'no',
            'ハ' => 'ha', 'ヒ' => 'hi', 'フ' => 'fu', 'ヘ' => 'he', 'ホ' => 'ho',
            'バ' => 'ba', 'ビ' => 'bi', 'ブ' => 'bu', 'ベ' => 'be', 'ボ' => 'bo',
            'パ' => 'pa', 'ピ' => 'pi', 'プ' => 'pu', 'ペ' => 'pe', 'ポ' => 'po',
            'マ' => 'ma', 'ミ' => 'mi', 'ム' => 'mu', 'メ' => 'me', 'モ' => 'mo',
            'ヤ' => 'ya', 'ユ' => 'yu', 'ヨ' => 'yo',
            'ラ' => 'ra', 'リ' => 'ri', 'ル' => 'ru', 'レ' => 're', 'ロ' => 'ro',
            'ワ' => 'wa', 'ヲ' => 'wo', 'ン' => 'n',
            'ッ' => 'tsu', 'ー' => '-',
            'ァ' => 'a', 'ィ' => 'i', 'ゥ' => 'u', 'ェ' => 'e', 'ォ' => 'o',
        ];

        // 2文字の組み合わせを先に変換（例：きゃ、しゃ）
        $text = strtr($text, array_merge($hiraganaMap, $katakanaMap));

        return $text;
    }
}