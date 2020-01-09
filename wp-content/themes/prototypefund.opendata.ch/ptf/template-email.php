<html>
<body>
<p>
    <b>Nutzername:</b> <?php echo $the_post["inputFirstname"] . ' ' . $the_post["inputLastname"] ?><br/>
    <b>Institution/Projekt:</b> <?php echo $the_post["inputInstitution"]; ?><br/>
    <b>E-Mail:</b> <a href="mailto:<?php echo $the_post["inputEmail"]; ?>"><?php echo $the_post["inputEmail"]; ?></a><br/>
</p>
<p>
    <a href="<?php echo get_edit_post_link($post_id);?>">Teilnehmerdetails</a>
</p>
<p>
    Regards,<br/>
    Der Prototypefund RSVP Roboter<br>
</p>
</body>
</html>