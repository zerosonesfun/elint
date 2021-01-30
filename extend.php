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

    var all_links = document.querySelectorAll('a');
    
    var excludes = ['domain0.com','www.domain1.com','domain2.com']; // Optionally exclude domains here
    
    for (var i = 0; i < all_links.length; i++){
        var a = all_links[i];
        var found = false; 
        for(j=0; j<excludes.length; j++) {
                if(a.href.includes(excludes[j])) {
                    found = true;
                    break;  
                }
        }    
        if (!found) {
            var links = document.links;
            for (var i = 0, linksLength = links.length; i < linksLength; i++) {
            if (links[i].hostname != window.location.hostname) {
                links[i].target = '_blank';
                links[i].rel = 'noopener nofollow ugc';
                links[i].classList.add('external-link');
             }
        }  

  });
</script>
HTML;
        })
];
