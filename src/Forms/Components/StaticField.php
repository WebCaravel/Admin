<?php

namespace WebCaravel\Admin\Forms\Components;

use Filament\Forms\Components\Placeholder;
use Illuminate\Support\HtmlString;

class StaticField extends Placeholder
{
    protected $link = null;
    protected bool $linkTargetBlank = false;


    protected function setUp(): void
    {
        parent::setUp();
        $name = $this->name;

        $this->content = function($record) use ($name) {
            $tmp = explode(".", $name);

            if(count($tmp) == 1) {
                return $record->$name;
            }
            else if(count($tmp) == 2) {
                $rel = $tmp[0];
                $key = $tmp[1];

                return optional($record->$rel)->$key;
            }
            else {
                throw new \Exception("Unknown StaticField name. Please only use one dot max.");
            }
        };
    }


    public function link(callable|string $link, bool $linkTargetBlank = false): static
    {
        $this->link = $link;
        $this->linkTarget = $linkTargetBlank;

        return $this;
    }


    public function getContent()
    {
        $content = $this->evaluate($this->content);

        if($link = $this->evaluate($this->link)) {
            $content = '<a href="' . $link .'" class="link"' . ($this->linkTargetBlank ? ' target="_blank"' : '') .'>' . $content . '</a>';
        }

        return new HtmlString($content);
    }
}
