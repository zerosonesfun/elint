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
(function () {
  function extendElint(output, vnode, event) {
    var context = vnode.attrs.post

    if ((event === 'oncreate' && context.customExtElintLastContentHtml !== context.contentHtml())
        || context.editedContent) {
      this.$('a').filter(function() {
        return this.hostname && this.hostname !== location.hostname;
      }).addClass('External-link');

      this.$('a[href$=".mp3"], a[href$=".ogg"], a[href$=".wav"], a[href$=".mp4"], a[href$=".m4a"], a[href$=".acc"], a[href$=".opus"], a[href$=".flac"]').filter(function() {
        return this.hostname && this.hostname !== location.hostname;
      }).removeClass('External-link');

      var rel = this.$('.External-link').attr('rel');
      if (rel == '' || rel.indexOf('noopener') === -1) {
        rel = rel + ' noopener';
      }
      this.$('.External-link').attr({ 'target': '_blank', 'rel': rel });
      context.customExtElintLastContentHtml = context.contentHtml();
    }
  }

  flarum.core.compat.extend.extend(flarum.core.compat['components/CommentPost'].prototype, 'oncreate', function (output, vnode) {
    extendElint(output, vnode, 'oncreate');
  });
  flarum.core.compat.extend.extend(flarum.core.compat['components/CommentPost'].prototype, 'onupdate', function (output, vnode) {
    extendElint(output, vnode, 'onupdate');
  });
})();
</script>
HTML;
        })
];