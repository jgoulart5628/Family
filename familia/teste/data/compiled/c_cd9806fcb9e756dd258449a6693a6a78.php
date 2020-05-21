



<?php echo $this->_fetch_compile("navbar.tpl"); ?>




<?php if (! $this->_vars['welcome_file']): ?>
<div id="specialpageslinks">
<?php if ($this->_vars['config']['use_comments']): ?>
<a href="?lastcommented=<?php echo $this->_vars['dir_url']; ?>
"><?php echo $this->_vars['txt_last_commented']; ?>
</a> |
<?php endif;  if ($this->_vars['config']['use_rating']): ?>
<a href="?toprated=<?php echo $this->_vars['dir_url']; ?>
"><?php echo $this->_vars['txt_top_rated']; ?>
</a> |
<?php endif; ?>
<a href="?lastaddedpictures=1"><?php echo $this->_vars['txt_last_added']; ?>
</a> |
<a href="?lastaddedpicturesperdir=1"><?php echo $this->_vars['txt_last_added_per_directory']; ?>
</a>
</div>
<?php endif; ?>




<?php if ($this->_vars['admin']): ?>
    <?php echo $this->_vars['admin_directory_settings']; ?>

    <?php echo $this->_vars['admin_edit_welcome']; ?>

<?php endif; ?>

<?php echo $this->_vars['welcome_file']; ?>



<?php if (! $this->_vars['startpic']): ?>

    <div id="dirlist">

    <?php if ($this->_vars['admin']): ?>
        <form name="deletedir" method="get" action="<?php echo $this->_vars['script_name']; ?>
">
        <input type="hidden" name="dir" value="" />
        <input type="hidden" name="deldir" value="" />
    <?php endif; ?>

    
    <?php if (count((array)$this->_vars['directories'])): foreach ((array)$this->_vars['directories'] as $this->_vars['directory']): ?>
    <div class="direntry">

        <?php if ($this->_vars['config']['directory_display_mode'] == 'picture'): ?>

           <div class="dirframe">
               <div class="fftop" style="width: <?php echo $this->_vars['directory']['frame_width']; ?>
px"><div><div>&nbsp;
               </div></div></div><!-- /fftop -->
               <div class="ffcontentwrap">
               <div class="ffcontent" style="width: <?php echo $this->_vars['directory']['frame_width']; ?>
px">
                  <a href="?dir=<?php echo $this->_vars['directory']['url']; ?>
" title="<?php echo $this->_vars['directory']['title']; ?>
">
                  <img src="<?php echo $this->_vars['directory']['cover_url']; ?>
" class="dirthumbnail" alt="<?php echo $this->_vars['directory']['title']; ?>
" /></a>
               </div><!-- /ffcontent -->
               </div><!-- /ffcontentwrap -->
               <div class="ffbottom" style="width: <?php echo $this->_vars['directory']['frame_width']; ?>
px"><div><div>&nbsp;
               </div></div></div><!-- /ffbottom -->
            </div><!-- /dirframe -->
            <div class="dirtitlepicture">
                <a href="?dir=<?php echo $this->_vars['directory']['url']; ?>
"><?php echo $this->_vars['directory']['title']; ?>
</a>
            <?php if ($this->_vars['admin']): ?>
                <?php echo $this->_vars['directory']['delete_dir_cross']; ?>

            <?php endif; ?>
            <div class="dirinfo">
                
                <?php if ($this->_vars['directory']['nb_subdirs']): ?>
                    <?php echo $this->_vars['directory']['nb_subdirs']; ?>
 <?php echo $this->_vars['txt']['dirs']; ?>

                <?php endif; ?> 
                <?php if ($this->_vars['directory']['nb_subdirs'] && $this->_vars['directory']['nb_files']): ?> - <?php endif; ?>
                <?php if ($this->_vars['directory']['nb_files']): ?>
                    <?php echo $this->_vars['directory']['nb_files']; ?>
 <?php echo $this->_vars['txt']['files']; ?>

                <?php endif; ?> 
            </div><!--//dirinfo-->
            </div><!--//dirtitlepicture-->

        <?php elseif ($this->_vars['config']['directory_display_mode'] == 'icon'): ?>

        <a href="?dir=<?php echo $this->_vars['directory']['url']; ?>
" title="<?php echo $this->_vars['directory']['title']; ?>
">
            <img src="base/images/folder.gif" class="diricon" alt="<?php echo $this->_vars['directory']['title']; ?>
" title="<?php echo $this->_vars['directory']['title']; ?>
" /> <?php echo $this->_vars['directory']['title']; ?>

        </a>

        <?php else: ?>

            <a href="?dir=<?php echo $this->_vars['directory']['url']; ?>
" title="<?php echo $this->_vars['directory']['title']; ?>
"><?php echo $this->_vars['directory']['title']; ?>
</a>

        <?php endif; ?>

    </div><!--//direntry-->
    <?php endforeach; endif; ?>

    <?php if ($this->_vars['admin']): ?></form><?php endif; ?>
    </div><!--//dirlist-->

<?php endif; ?>




<table id="dircontent">
    
    <?php if (! $this->_vars['thumbnails']): ?>
    
    <tr><td>&nbsp;</td></tr>
    <?php endif; ?>
    <?php if (count((array)$this->_vars['thumbnails'])): foreach ((array)$this->_vars['thumbnails'] as $this->_vars['tablerow']): ?>
    <tr>
        <?php if (count((array)$this->_vars['tablerow'])): foreach ((array)$this->_vars['tablerow'] as $this->_vars['thumb']): ?>
        <td style="width: <?php echo $this->_vars['td_width']; ?>
%">
            <?php if ($this->_vars['thumb']['link']): ?><a href="<?php echo $this->_vars['thumb']['link']; ?>
" title="<?php echo $this->_vars['thumb']['title']; ?>
" class="picthumbnail"><?php endif; ?>
            <img src="<?php echo $this->_vars['thumb']['url']; ?>
" alt="<?php echo $this->_vars['thumb']['title']; ?>
" class="<?php echo $this->_vars['thumb']['class']; ?>
" />
            <?php if ($this->_vars['thumb']['link']): ?></a><?php endif; ?>
            <div class="picinfo">
            <?php if ($this->_vars['thumb']['link']): ?><a href="<?php echo $this->_vars['thumb']['link']; ?>
" title="<?php echo $this->_vars['thumb']['title']; ?>
"><?php endif; ?>
            <?php if ($this->_vars['thumb']['title']): ?>
                <?php echo $this->_vars['thumb']['title']; ?>

            <?php else: ?>
                <?php echo $this->_vars['thumb']['name']; ?>

            <?php endif; ?>
            <?php if ($this->_vars['thumb']['link']): ?></a><?php endif; ?>
            <?php if ($this->_vars['thumb']['nb_comments']): ?>
                <span><?php echo $this->_vars['thumb']['nb_comments']; ?>
 <?php echo $this->_vars['txt']['thumb_comments']; ?>
</span>
            <?php endif; ?>
            <?php if ($this->_vars['thumb']['rating']): ?>
                <span><?php echo $this->_vars['txt']['thumb_rating']; ?>
 <b><?php echo $this->_vars['thumb']['rating']; ?>
</b></span>
            <?php endif; ?>
            <?php if ($this->_vars['admin'] && $this->_vars['config']['directory_display_mode']): ?>
                <span><?php echo $this->_vars['thumb']['select_as_cover']; ?>
</span>
            <?php endif; ?>
            </div><!--//picinfo-->
        </td>
        <?php endforeach; endif; ?>
    </tr>
    <?php endforeach; endif; ?>
</table>
<div id="pagenav"><?php echo $this->_vars['pager']; ?>
</div>

