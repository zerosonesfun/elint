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
  flarum.core.compat.extend.extend(flarum.core.compat['components/CommentPost'].prototype, 'oncreate', function(output, vnode) {

      $('a').filter(function() {
        return this.hostname && this.hostname !== location.hostname; 
        }).addClass('External-link');

      $('a[href$=".mp3"], a[href$=".ogg"], a[href$=".wav"], a[href$=".mp4"], a[href$=".m4a"], a[href$=".acc"], a[href$=".opus"], a[href$=".flac"]').filter(function() {
        return this.hostname && this.hostname !== location.hostname; 
        }).removeClass('External-link');

      var rel = this.$('.External-link').attr('rel');
      this.$('.External-link').attr('target','_blank').attr('rel',rel + ' noopener');

  });
</script>
HTML;
        })
];
