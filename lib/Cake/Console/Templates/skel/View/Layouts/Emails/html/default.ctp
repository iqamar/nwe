<style type="text/css">
    body,td,th {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14px; color:#000;
    }
    h1,h2,h3,h4,h5,h6 {
        font-family: Arial, Helvetica, sans-serif; font-size:15px;
    }
    img{ border:0px;}
    td{padding:0px;}
    span{margin:0px; padding:0px;}
</style>
<table width="100%" border="0" cellspacing="0">
    <tr>
        <td bgcolor="#f2f2f2">
            <table width="550"align="center" cellpadding="0" cellspacing="0" style="margin-top:10px; margin-bottom:10px;">
                <tr>
                    <td height="60" colspan="3" bgcolor="#000000"><table width="100%" border="0" cellspacing="3" cellpadding="1">
                            <tr>
                                <td width="32%"><a href="http://www.<?php echo SITE_TITLE ?>.com" target="_blank"><img src="<?php echo MEDIA_URL ?>/img/networkwe_logo_inner.png" alt="<?php echo SITE_TITLE ?> Logo" title="<?php echo SITE_TITLE ?> Logo" style="margin-left:4px;"></a></td>
                                <td width="54%"><strong><font color="#DFDFDF">its all about you &amp; the world around you</font></strong></td>
                                <td width="14%"><a href="http://www.<?php echo SITE_TITLE ?>.com" target="_blank"><img src="<?php echo MEDIA_URL ?>/img/see_all_button.png" alt="See All" width="74" height="26"></a></td>
                            </tr>
                        </table></td>
                </tr> 
                <tr>
                    <td colspan="3" valign="top" bgcolor="#FFFFFF">
                        <?php echo $this->fetch('content'); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" bgcolor="#000000">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:10px 0px;">
                            <tr>
                                <td align="center"><span style="font-size:10px; color:#DFDFDF; text-align:center;"><?php echo SITE_TITLE ?> Updates you are receiving daily via email</span></td>
                            </tr>
                            <tr>
                                <td align="center"><a href="http://www.<?php echo SITE_TITLE ?>.com" target="_blank" style="font-size:10px; color:#DFDFDF; text-decoration:underline;">unsubscribe</a> <span  style="font-size:10px; color:#DFDFDF;">updates from <?php echo SITE_TITLE ?>.com</span></td>
                            </tr>
                            <tr>
                                <td align="center"><span  style="font-size:10px; color:#DFDFDF; text-align:center;"><?php echo SITE_TITLE ?>.com &copy; 2014</span></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>