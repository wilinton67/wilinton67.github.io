<?php
function check_doc_mime($tmpname)
{
    $finfo = finfo_open(FILEINFO_MIME_TYPE);

    $mtype = finfo_file($finfo, $tmpname);
    finfo_close($finfo);

    if ($mtype == ("text/html") || $mtype == ("audio/mpeg")) {
        return true;
    } else {
        return false;
    }
}
