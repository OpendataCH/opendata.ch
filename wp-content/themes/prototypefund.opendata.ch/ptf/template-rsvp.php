<div class="row">
    <div class="col-xs-24 ptf-rsvp-wrap">
        <?php if(get_field('rsvp_headline',$post->ID)) {?>
            <h3><?php the_field('rsvp_headline',$post->ID); ?></h3>
        <?php }; ?>
        <form id="rsvp-form" data-event="<?php the_field('rsvp_eventname',$post->ID); ?>" class="ptf-form" method="post" action="">
            <div class="row">
                <div class="col-xs-24 col-md-12 no-padding-right">
                    <div class="form-group">
                        <div class="form-field">
                            <input type="text" maxlength="200" class="form-control mandatory" name="inputFirstname" placeholder="Vorname*">
                            <div class="error-msg" >Bitte gebe deinen Vornamen an</div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-24 col-md-12 no-padding-right">
                    <div class="form-group">
                        <div class="form-field">
                            <input type="text" maxlength="200" class="form-control mandatory" name="inputLastname" placeholder="Nachname*">
                            <div class="error-msg" >Bitte gebe deinen Nachnamen an</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-24 col-md-12 no-padding-right">
                    <div class="form-group">
                        <div class="form-field">
                            <input type="text" maxlength="200" class="form-control" name="inputInstitution" placeholder="Institution/Projekt">
                            <div class="error-msg" >Bitte gib Institution/Projekt an</div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-24 col-md-12 no-padding-right">
                    <div class="form-group">
                        <div class="form-field">
                            <input type="email" maxlength="250" class="form-control mandatory" name="inputEmail" placeholder="Email*">
                            <div class="error-msg" >
                                <span class="error-0">Bitte gib eine E-Mail Adresse an</span>
                                <span class="error-1">Bitte überprüfe deine E-Mail Adresse.</span>
                            </div>
                            <div class="already-in-text hidden">Diese E-Mail Adresse wurde bereits für dieses Event registriert.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-24">
                    <div class="loading-spinner hidden"></div>
                    <p class="submit-error-text error-msg hidden">Beim Versenden ist ein Fehler aufgetreten.</p>
                    <div class="button-submit button-with-arrow mc-embedded-subscribe button">
                        <span>Anmelden</span>
                        <div class="submit-arrow svg-nav-arrow-big svg-nav-arrow-big-dims"></div>
                    </div>
                    <!--<a class="button-submit boxed-link page blue" href="#">ANMELDEN</a>-->
                </div>
            </div>
        </form>
        <div class="row success-message hidden">
            <div class="col-xs-24">
                <?php the_field('rsvp_usermessage',$post->ID); ?>
            </div>
        </div>
    </div>
</div>