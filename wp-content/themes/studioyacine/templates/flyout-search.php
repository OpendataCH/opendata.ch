<?php
// ===================================================
// FLYOUT SEARCH
// ===================================================
// ===================================================
// ===================================================
?>
<div class="Searchoverlay">

    <div class="Searchoverlay--inner">

        <?php get_search_form(); ?>

    </div>

    <button type='button' class='Searchoverlay--close'>

        <span class='visuallyhidden'>Close</span>
        <svg aria-hidden='true' class="icon">
            <use xlink:href="#base--close(1)"></use>
        </svg>

    </button>

    <div class="Search--overlay"></div>

</div>