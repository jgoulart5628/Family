<?php require_once('/home/apache/familia/teste/base/3rd-part/class.template/plugins/function.cycle.php'); $this->register_function("cycle", "tpl_function_cycle"); ?>



<?php echo $this->_fetch_compile("navbar.tpl"); ?>





<div id="displaypicture">
    <div id="pictitle">
    <span class="big"><?php echo $this->_vars['picture']['title']; ?>
</span>

    <?php if ($this->_vars['config']['use_iptc']): ?>
        <span id="metadataicon">
        <?php if ($this->_vars['picture']['metadata_found']): ?>
            <img src="<?php echo $this->_vars['base_images_dir']; ?>
metadata_on.gif" alt="<?php echo $this->_vars['txt']['Found_IPTC_metadata']; ?>
" title="<?php echo $this->_vars['txt']['Found_IPTC_metadata']; ?>
" />
        <?php else: ?>
            <img src="<?php echo $this->_vars['base_images_dir']; ?>
metadata_off.gif" alt="<?php echo $this->_vars['txt']['No_IPTC_metadata_found']; ?>
" title="<?php echo $this->_vars['txt']['No_IPTC_metadata_found']; ?>
" />
        <?php endif; ?>
        </span>
    <?php endif; ?>
    </div><!--//pictitle-->
    <div id="picnav">
        <?php echo $this->_vars['picnavbar']; ?>

    </div><!--//picnav-->
    
    <?php if ($this->_vars['admin']): ?>
        <?php echo $this->_vars['adminpicturebox']; ?>

    <?php endif; ?>

    <?php if ($this->_vars['config']['use_rating']): ?>
        <div id="currentrating">
        <?php if ($this->_vars['rating']['current_rating_raw']): ?>
            <?php echo $this->_vars['txt']['pic_rating']; ?>
 <?php echo $this->_vars['rating']['current_rating_formatted']; ?>

        <?php else: ?>
            <?php echo $this->_vars['txt']['no_rating']; ?>

        <?php endif; ?>
        <?php if (! $this->_vars['rating']['already_rated']): ?>
            <form id="picrating" action="<?php echo $this->_vars['script_name']; ?>
" method="post">
            <input type="hidden" name="display" value="<?php echo $this->_vars['display']; ?>
" />
            <select name="rating" onchange='document.location.href="<?php echo $this->_vars['rating']['form_url']; ?>
" + this.options[this.selectedIndex].value'>
                <option value='null'><?php echo $this->_vars['txt']['option_rating']; ?>
</option>
            <?php if (count((array)$this->_vars['rating']['select_options'])): foreach ((array)$this->_vars['rating']['select_options'] as $this->_vars['option_rating']): ?>
                <option value="<?php echo $this->_vars['option_rating']['value']; ?>
"><?php echo $this->_vars['option_rating']['text']; ?>
</option>
            <?php endforeach; endif; ?>
            </select>
            <noscript><button type="submit"><?php echo $this->_vars['txt']['rate']; ?>
</button></noscript>
            </form><!--picrating-->
        <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ($this->_vars['picture']['link']): ?>
        <a href="<?php echo $this->_vars['picture']['link']; ?>
" title="<?php echo $this->_vars['picture']['link_title']; ?>
">
    <?php endif; ?>
    <?php if ($this->_vars['picture']['type'] == 'image'): ?>
        <img src="<?php echo $this->_vars['picture']['url']; ?>
" alt="<?php echo $this->_vars['picture']['title']; ?>
" class="picture" />
    <?php elseif ($this->_vars['picture']['type'] == 'video'): ?>

        

        <?php if ($this->_vars['picture']['player'] == 'qt'): ?>

            <object classid='clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B' width="320"
            height="240" codebase='http://www.apple.com/qtactivex/qtplugin.cab'>
                <param name='src' value="<?php echo $this->_vars['picture']['url']; ?>
">
                <param name='autoplay' value="true">
                <param name='controller' value="true">
                <param name='loop' value="true">
                <embed src="<?php echo $this->_vars['picture']['url']; ?>
" width="320" height="240" autoplay="true" 
                controller="true" loop="true" pluginspage='http://www.apple.com/quicktime/download/'>
                </embed>
            </object>

        <?php elseif ($this->_vars['picture']['player'] == 'wmp'): ?>

            <object width="320" height="240" 
          classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" 
          codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701"
          standby="Loading Microsoft Windows Media Player components..." type="application/x-oleobject">
          <param name="fileName" value="<?php echo $this->_vars['picture']['url']; ?>
">
          <param name="animationatStart" value="true">
          <param name="transparentatStart" value="true">
          <param name="autoStart" value="true">
          <param name="showControls" value="true">
          <param name="loop" value="false">
          <embed type="application/x-mplayer2"
            pluginspage="http://microsoft.com/windows/mediaplayer/en/download/"
            name="mediaPlayer" displaysize="4" autosize="-1" 
            bgcolor="darkblue" showcontrols="true" showtracker="-1" 
            showdisplay="0" showstatusbar="-1" videoborder3d="-1" width="320" height="240"
            src="<?php echo $this->_vars['picture']['url']; ?>
" autostart="true" designtimesp="5311" loop="false">
          </embed>
          </object>
        <?php elseif ($this->_vars['picture']['player'] == 'rp'): ?>

            <!-- begin video window... -->
            <object classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA"
            width="320" height="240">
            <param name="src" value="<?php echo $this->_vars['picture']['url']; ?>
">
            <param name="autostart" value="true">
            <param name="controls" value="imagewindow">
            <param name="console" value="video">
            <param name="loop" value="true">
            <embed src="<?php echo $this->_vars['picture']['url']; ?>
" width="320" height="240" 
            loop="true" type="audio/x-pn-realaudio-plugin" controls="imagewindow" console="video" autostart="true">
            </embed>
            <!-- ...end video window -->
            <!-- begin control panel... -->
            </object><br /><object classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA'
              width="320" height="30">
              <param name="src" value="<?php echo $this->_vars['picture']['url']; ?>
">
              <param name="autostart" value="true">
              <param name="controls" value="ControlPanel">
              <param name="console" value="video">
              <embed src="<?php echo $this->_vars['picture']['url']; ?>
" width="320" height="30" 
              controls="ControlPanel" type="audio/x-pn-realaudio-plugin" console="video" autostart="true">
              </embed>
              </object>
            <!-- ...end control panel -->

        <?php elseif ($this->_vars['picture']['player'] == 'flash'): ?>

            <object type="application/x-shockwave-flash" data="<?php echo $this->_vars['picture']['url']; ?>
" width="320" height="240" >
                <param name="movie" value="<?php echo $this->_vars['picture']['url']; ?>
" />
                <param name="quality" value="high" />
                <param name="menu" value="true" />
            </object>

        <?php elseif ($this->_vars['picture']['player'] == 'flv'): ?>

            <div id="flvplayer"><a href="http://www.macromedia.com/go/getflashplayer">Get Flash</a> to see this player.</div>
            <script type="text/javascript">
                var so = new SWFObject('base/3rd-part/flv-player/flvplayer.swf','player','400','400','7');
                so.addParam("allowfullscreen","true");
                <?php if ($this->_vars['use_direct_urls']): ?>
                so.addVariable("file","../../../<?php echo $this->_vars['picture']['url']; ?>
");
                <?php else: ?>
                so.addVariable("file","<?php echo $this->_vars['picture']['url']; ?>
");
                <?php endif; ?>
                so.addVariable("displayheight","300");
                so.addVariable("title","<?php echo $this->_vars['picture']['name']; ?>
");
                so.write('flvplayer');
            </script>

        <?php endif; ?>
    <?php elseif ($this->_vars['picture']['type'] == 'audio'): ?>
        <a href="<?php echo $this->_vars['picture']['url']; ?>
"><img src="base/images/sound.gif" alt="<?php echo $this->_vars['picture']['title']; ?>
" class="icon" /></a>
    <?php else: ?>
        <img src="base/images/unknown.gif" alt="<?php echo $this->_vars['picture']['title']; ?>
" class="icon" />
    <?php endif; ?>
    <?php if ($this->_vars['picture']['link']): ?></a><?php endif; ?>
    
    <?php if ($this->_vars['config']['use_exif'] && $this->_vars['picture']['formatted_exif_metadata']): ?>
        <div class="exifmetadata">
        <?php echo $this->_vars['picture']['formatted_exif_metadata']; ?>

        </div>
    <?php endif; ?>
    <?php if ($this->_vars['config']['use_iptc'] && $this->_vars['picture']['formatted_iptc_metadata']): ?>
        <div class="iptcmetadata">
        <?php echo $this->_vars['picture']['formatted_iptc_metadata']; ?>

        </div>
    <?php endif; ?>
    <?php if (( $this->_vars['config']['use_iptc'] || $this->_vars['config']['use_exif'] ) && $this->_vars['picture']['metadata_array']): ?>
        <div style="text-align: center">
            <a href="javascript:switch_display('metadatadiv')"><?php echo $this->_vars['txt']['show_me_more']; ?>
</a>
        </div>
        <div id="metadatadiv" style="display:none">
          <table class="metadatatable">
          <?php if (count((array)$this->_vars['picture']['metadata_array'])): foreach ((array)$this->_vars['picture']['metadata_array'] as $this->_vars['key'] => $this->_vars['value']): ?>
          <tr class="<?php echo tpl_function_cycle(array('values' => "rowbgcolor1, rowbgcolor2"), $this);?>"><td align="left"><?php echo $this->_vars['key']; ?>
</td><td><?php echo $this->_vars['value']; ?>
</td></tr>
          <?php endforeach; endif; ?>
          </table>
        </div><!--//metadatadiv-->
    <?php endif; ?>
    <?php if ($this->_vars['picture']['type'] != 'image'): ?>
    <a href="<?php echo $this->_vars['picture']['url'];  if (! $this->_vars['use_direct_urls']): ?>&amp;mode=saveas<?php endif; ?>"><img src="base/images/save-as.png" class="icon" alt="<?php echo $this->_vars['txt']['Save_as']; ?>
" title="<?php echo $this->_vars['txt']['Save_as']; ?>
" /></a>
    <?php endif; ?>

    <?php if ($this->_vars['config']['use_comments']): ?>
    <div id="comments">
    <span id="commentstitle"><?php echo $this->_vars['txt']['comments']; ?>
</span>
    <?php if ($this->_vars['picture']['user_can_post_comments']): ?>
        <span id="addcomment"><a href="#" onclick="enterWindow=window.open('?picname=<?php echo $this->_vars['picture']['path']; ?>
&amp;addcomment=1&amp;popup=1','commentadd','width=400,height=260,top=250,left=500'); return false"><?php echo $this->_vars['txt']['add_comment']; ?>
</a></span>
    <?php endif; ?>
    <?php if ($this->_vars['comments']): ?>
        <?php if (count((array)$this->_vars['comments'])): foreach ((array)$this->_vars['comments'] as $this->_vars['comment']): ?>
        <div class="small commentfrom"><?php echo $this->_vars['txt']['comment_from']; ?>
<b><?php echo $this->_vars['comment']['user']; ?>
</b><?php echo $this->_vars['txt']['comment_on']; ?>
 <?php echo $this->_vars['comment']['datetime']; ?>

        <?php if ($this->_vars['admin']): ?>
             | <a href="?display=<?php echo $this->_vars['picture']['path']; ?>
&amp;delcom=<?php echo $this->_vars['comment']['id']; ?>
"><?php echo $this->_vars['txt']['del_comment']; ?>
</a>
        <?php endif; ?>
        </div>
        <div class="usercomment"><?php echo $this->_vars['comment']['text']; ?>
</div>
        <?php endforeach; endif; ?>
    <?php endif; ?>
    </div><!--//comments-->
    <?php endif; ?>

</div><!--//displaypicture-->
