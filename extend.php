<?php

/*
 * A Flarum extension created by Billy Wilcosky.
 * Opens external links in a new tab but leaves internal links alone.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * For instructions, please view the README file.
 */

use Flarum\Extend;
use Flarum\Frontend\Document;

return [
    (new Extend\Frontend('forum'))
        ->content(function (Document $document) {
 $document->foot[] = <<<HTML
<script>
  flarum.core.compat.extend.extend(flarum.core.compat['components/CommentPost'].prototype, 'config', function(output, isInitialized, context) {
    if (context.custommExtLastContentHtml !== context.contentHtml) {

      $('a').filter(function() {
        return this.hostname && this.hostname !== location.hostname; 
        }).addClass('External-link');

      $('a[href$=".mp3"], a[href$=".ogg"], a[href$=".wav"], a[href$=".mp4"], a[href$=".m4a"], a[href$=".acc"], a[href$=".opus"], a[href$=".flac"]').filter(function() {
        return this.hostname && this.hostname !== location.hostname; 
        }).removeClass('External-link');

      var rel = $('.External-link').attr('rel');
      $('.External-link').attr('target','_blank').attr('rel',rel + ' noopener');

    }
      
    context.custommExtLastContentHtml = context.contentHtml;
  });
</script>
HTML;
        })
];
