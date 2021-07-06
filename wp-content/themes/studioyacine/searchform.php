<form role="search" method="get" class="searchform" action="<?php echo home_url('/'); ?>">

    <label class='visuallyhidden' for="s">Search</label>
    
    <input type="search" id="s" name="s" placeholder='Enter a search term' value="" />

    <button type="submit" id="searchsubmit"><?php _e('Search', 'bonestheme'); ?></button>

</form>