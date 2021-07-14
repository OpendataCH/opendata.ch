<form role="search" method="get" class="searchform" action="<?php echo home_url('/'); ?>">
	
    <label class='visuallyhidden' for="<?php echo($args['name']);  ?>">Search</label>
    
    <input type="search" id="<?php echo($args['name']);  ?>" name="<?php echo($args['name']);  ?>" placeholder='Enter a search term' value="" />

    <button type="submit" id="searchsubmit"><?php _e('Search', 'bonestheme'); ?></button>

</form>