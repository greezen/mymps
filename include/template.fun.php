<?php
function myparsetemplate( $tplfile, $templateid, $tpldir )
{
    global $timestamp;
    global $mytemplates;
    $nest = 6;
    $file = basename( $tplfile, ".html" );
    $objfile = MYMPS_DATA.( "/templates/".$templateid."_{$file}.tpl.php" );
    if ( !( $fp = @fopen( $tplfile, "r" ) ) )
    {
        exit( "Current template file './".$tpldir."/{$file}.html' not found or have no access!" );
    }
    $template = @fread( $fp, @filesize( $tplfile ) );
    fclose( $fp );
    $var_regexp = "((\\\$[a-zA-Z_-ÿ][a-zA-Z0-9_-ÿ]*)(\\[[a-zA-Z0-9_\\-\\.\"\\'\\[\\]\$-ÿ]+\\])*)";
    $const_regexp = "([a-zA-Z_-ÿ][a-zA-Z0-9_-ÿ]*)";
    $mytemplates = array( );
    $i = 1;
    for ( ; $i <= 3; ++$i )
    {
        if ( strexists( $template, "{mytemplate" ) )
        {
            $template = preg_replace( "/[\n\r\t]*\\{mytemplate\\s+([a-z0-9_]+)\\}[\n\r\t]*/ies", "loadmytemplate('\\1')", $template );
        }
    }
    $template = preg_replace( "/([\n\r]+)\t+/s", "\\1", $template );
    $template = preg_replace( "/\\<\\!\\-\\-\\{(.+?)\\}\\-\\-\\>/s", "{\\1}", $template );
    $template = str_replace( "{LF}", "<?=\"\\n\"?>", $template );
    $template = preg_replace( "/\\{(\\\$[a-zA-Z0-9_\\[\\]\\'\"\$\\.-ÿ]+)\\}/s", "<?=\\1?>", $template );
    $template = preg_replace( "/".$var_regexp."/es", "addquote('<?=\\1?>')", $template );
    $template = preg_replace( "/\\<\\?\\=\\<\\?\\=".$var_regexp."\\?\\>\\?\\>/es", "addquote('<?=\\1?>')", $template );
    $headeradd = "";
    if ( !empty( $mytemplates ) )
    {
        $headeradd .= "\n0\n";
        foreach ( $mytemplates as $fname )
        {
            $headeradd .= "|| chktplrefresh('".$tplfile."', '{$fname}', {$timestamp}, '{$templateid}', '{$tpldir}')\n";
        }
        $headeradd .= ";";
    }
    $template = "<?php if(!defined('IN_MYMPS')) exit('Access Denied');\r\n/*Mymps·ÖÀàÐÅÏ¢ÏµÍ³\r\n¹Ù·½ÍøÕ¾£ºhttp://zhideyao.cn*/\r\n\r\n?>\r\n\r\n".$template;
    $template = preg_replace( "/[\n\r\t]*\\{mympstag_([a-z0-9_]+)\\}[\n\r\t]*/is", "\n<?php echo custom('\\1'); ?>\n", $template );
    $template = preg_replace( "/[\n\r\t]*\\{template\\s+([a-z0-9_]+)\\}[\n\r\t]*/is", "\n<?php include mymps_tpl('\\1'); ?>\n", $template );
    $template = preg_replace( "/[\n\r\t]*\\{php\\s+(.+?)\\}[\n\r\t]*/ies", "stripvtags('<?php \\1 ?>','')", $template );
    $template = preg_replace( "/[\n\r\t]*\\{php\\}\\s*(\\<\\!\\-\\-)*(.+?)(\\-\\-\\>)*\\s*\\{\\/php\\}[\n\r\t]*/ies", "stripvtags('<?php \\2 ?>','')", $template );
    $template = preg_replace( "/[\n\r\t]*\\{echo\\s+(.+?)\\}[\n\r\t]*/ies", "stripvtags('<? echo \\1; ?>','')", $template );
    $template = preg_replace( "/([\n\r\t]*)\\{if\\s+(.+?)\\}([\n\r\t]*)/ies", "stripvtags('\\1<? if(\\2) { ?>\\3')", $template );
    $template = preg_replace( "/([\n\r\t]*)\\{elseif\\s+(.+?)\\}([\n\r\t]*)/ies", "stripvtags('\\1<?php } elseif(\\2) { ?>\\3','')", $template );
    $template = preg_replace( "/([\n\r\t]*)\\{else\\}([\n\r\t]*)/is", "\\1<?php } else { ?>\\2", $template );
    $template = preg_replace( "/\\{\\/if\\}/i", "<?php } ?>", $template );
    $template = preg_replace( "/[\n\r\t]*\\{loop\\s+(\\S+)\\s+(\\S+)\\}[\n\r\t]*/ies", "stripvtags('<?php if(is_array(\\1)){foreach(\\1 as \\2) { ?>')", $template );
    $template = preg_replace( "/[\n\r\t]*\\{loop\\s+(\\S+)\\s+(\\S+)\\s+(\\S+)\\}[\n\r\t]*/ies", "stripvtags('<?php if(is_array(\\1)){foreach(\\1 as \\2 => \\3) { ?>')", $template );
    $template = preg_replace( "/([\n\r\t]*)\\{loopelse\\}([\n\r\t]*)/is", "\\1<?php }} else {{ ?>\\2", $template );
    $template = preg_replace( "/\\{\\/loop\\}/i", "<?php }} ?>", $template );
    $template = preg_replace( "/{".$const_regexp."\\}/s", "<?=\\1?>", $template );
    $template = preg_replace( "/ \\?\\>[\n\r]*\\<\\? /s", " ", $template );
    $template = str_replace( "\$db_mymps", "{\$db_mymps}", $template );
    if ( !( $fp = @fopen( $objfile, "w" ) ) )
    {
        exit( "Directory '/data/templates/' not found or have no access!" );
    }
    flock( $fp, 2 );
    fwrite( $fp, $template );
    fclose( $fp );
}

function loadmytemplate( $file, $templateid = 0, $tpldir = "" )
{
    global $mytemplates;
    $tpldir = $tpldir ? $tpldir : TPLDIR;
    $templateid = $templateid ? $templateid : TEMPLATEID;
    $tplfile = MYMPS_ROOT."/template/".$tpldir."/".$file.".html";
    if ( $templateid != 1 && !file_exists( $tplfile ) )
    {
        $tplfile = MYMPS_ROOT."/template/default/".$file.".html";
    }
    $content = @implode( "", @file( $tplfile ) );
    $mytemplates[] = $tplfile;
    return $content;
}

function transamp( $str )
{
    $str = str_replace( "&", "&amp;", $str );
    $str = str_replace( "&amp;amp;", "&amp;", $str );
    $str = str_replace( "\\\"", "\"", $str );
    return $str;
}

function addquote( $var )
{
    return str_replace( "\\\"", "\"", preg_replace( "/\\[([a-zA-Z0-9_\\-\\.-ÿ]+)\\]/s", "['\\1']", $var ) );
}

function stripvtags( $expr, $statement )
{
    $expr = str_replace( "\\\"", "\"", preg_replace( "/\\<\\?\\=(\\\$.+?)\\?\\>/s", "\\1", $expr ) );
    $statement = str_replace( "\\\"", "\"", $statement );
    return $expr.$statement;
}

function stripscriptamp( $s, $extra )
{
    $extra = str_replace( "\\\"", "\"", $extra );
    $s = str_replace( "&amp;", "&", $s );
    return "<script src=\"".$s."\" type=\"text/javascript\"{$extra}></script>";
}

function stripblock( $var, $s )
{
    $s = str_replace( "\\\"", "\"", $s );
    $s = preg_replace( "/<\\?=\\\$(.+?)\\?>/", "{\$\\1}", $s );
    preg_match_all( "/<\\?=(.+?)\\?>/e", $s, $constary );
    $constadd = "";
    $constary[1] = array_unique( $constary[1] );
    foreach ( $constary[1] as $const )
    {
        $constadd .= "\$__".$const." = ".$const.";";
    }
    $s = preg_replace( "/<\\?=(.+?)\\?>/", "{\$__\\1}", $s );
    $s = str_replace( "?>", "\n\$".$var." .= <<<EOF\n", $s );
    $s = str_replace( "<?", "\nEOF;\n", $s );
    return "<?\n".$constadd."\${$var} = <<<EOF\n".$s."\nEOF;\n?>";
}

function chktplrefresh( $maintpl, $subtpl, $timecompare, $templateid, $tpldir )
{
    global $mymps_mymps;
    if ( ( empty( $timecompare ) || $mymps_mymps['tplrefresh'] == 1 ) && $timecompare < @filemtime( $subtpl ) )
    {
        myparsetemplate( $subtpl, $templateid, $tpldir );
        return TRUE;
    }
    return FALSE;
}

if ( !defined( "IN_MYMPS" ) )
{
    exit( "Access Denied" );
}
?>
