<?php

namespace App\Support;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;
use Mews\Purifier\Facades\Purifier;

class Markdown
{
    public static function toSafeHtml(?string $markdown): string
    {
        $markdown = $markdown ?? '';

        $environment = new Environment([
            'allow_unsafe_links' => false,
        ]);
        $environment->addExtension(new CommonMarkCoreExtension());

        $converter = new MarkdownConverter($environment);
        $html = (string) $converter->convert($markdown);

        $clean = Purifier::clean($html);

        $clean = preg_replace(
            '/<a([^>]*target="_blank"[^>]*)>/i',
            '<a$1 rel="noopener noreferrer">',
            $clean
        );

        return $clean;
    }

    public static function excerpt(?string $markdown, int $limit = 160): string
    {
        $html = self::toSafeHtml($markdown);
        $text = trim(preg_replace('/\s+/', ' ', strip_tags($html)));
        return \Illuminate\Support\Str::limit($text, $limit);
    }
}
