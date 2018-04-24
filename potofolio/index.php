<?PHP
ob_start("ob_gzhandler");
/*******************************************************************************
 *  tFotoView, wersja: 0.2
 *
 *  Skrypt pomagaj±cy przegl±danie zdjêæ na stronie
 *  Info szukaj na http://tas.klamstwo.org
 *
 *******************************************************************************
 *  Autor: Maciej "tas" Litwiniuk
 *  E-mail: <tas@xcom.pl>
 *  WWW: http://tas.klamstwo.org/
 *  Utworzone (dd-mm-rrrr): 12-06-2003
 *  Zmodyfikowane (dd-mm-rrrr): 12-06-2003
 *******************************************************************************
 *  Skrypt ten mo¿e byæ dowolnie modyfikowany i rozpowszechniany pod warunkiem
 *  zachowania niniejszego nag³ówka.
 *
 *  Ten skrypt dostarczany jest przez autora w formie "takiej, jaki jest".
 *  Autor nie udziela ¿adnej gwarancji oraz rêkojmi, ¿e skrypt bêdzie dzia³aæ
 *  prawid³owo, jest odpowiedniej jako¶ci oraz ¿e spe³ni oczekiwania
 *  u¿ytkownika. Autor nie odpowiada za jakiekolwiek straty wynik³e z u¿ywania
 *  skryptu, w tym utratê spodziewanych korzy¶ci, danych, informacji
 *  gospodarczych lub koszt urz±dzeñ lub programów zastêpczych.
 ******************************************************************************/
 
$title="tFotoView v0.2";
$param=""; //parametry dodatkowo przekazywane przy wywo³aniu strony, np. ala=2&g=5
$show_style="0" /*jak pokazywaæ zdjêcia na stronie g³ównej - 1 - lista, 0 - miniaturki;
miniaturki bêd± wyszukiwane w podkatalogach 'small' i 'mini',
gdy takie nie istniej±, zostanie wy¶wietlona lista zdjêæ bez pomniejszania*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<HTML>
<HEAD>
<meta http-equiv="Content-type" content="text/html; charset=iso-8859-2" />
<meta http-equiv="Creation-date" content="2003-06-12T11:36:38Z" />
<meta http-equiv="Reply-to" content="tas@xcom.pl" />
<meta http-equiv="Content-Language" content="pl" />
<meta name="Author" content="tas" />
<?PHP echo "<TITLE>$title</TITLE>"; ?>
<STYLE TYPE="text/css">
<!--
BODY {
        font-family: verdana;
        font-size: 8pt;
        color: #333333;
		background: #FFFFFF;
}
TD {
        font-family: verdana;
        font-size: 8pt;
        color: #333333;
		background: #FFFFFF;
}
A{
        color: #000000;
}
.small {
		font-family: Verdana;
		font-size: 7pt;
		color: #333333;	
}
IMG {
		border: 1px solid;
		border-color: #000000;
}
SMALL {
		font-family: Verdana;
		font-size: 7pt;
		color: #333333;
}
-->
</STYLE>
</HEAD>
<body leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0" marginwidth="0" marginheight="0">
<table border=0 width=100% align=center cellpadding=0 cellspacing=0><TR><TD width=100> </td><td>
<?PHP
if(!isset($foto)) {
    //wy¶wietlenie listy
    echo "<b>$title</b><br><BR>";
    $OpenDir=opendir("./");
    $i=0;
    while (($katalog = readdir($OpenDir))!=false) {
        if(($katalog!=".")&&($katalog!="..")&&(!is_dir($katalog)) &&(substr($katalog,-4)==".jpg")||(substr($katalog,-4)==".JPG")) {
        		$i++;
        		if($show_style=="1"){
	            echo("<a href='?foto=$katalog&$param'>$i</a>&nbsp; ");
	         }elseif($show_style=="0"){
	         	if(file_exists("small/".$katalog)){
		         	echo("<a href='?foto=$katalog&$param'><img src='small/$katalog'></a>&nbsp; ");
		         }elseif(file_exists("mini/".$katalog)){
		         	echo("<a href='?foto=$katalog&$param'><img src='mini/$katalog'></a>&nbsp; ");
		         }else{
		         	echo("<a href='?foto=$katalog&$param'><img src='$katalog'></a>&nbsp; ");
		         }
	         }
        }
    }
    echo("<BR><p class=small align=left>tFotoView by tas - <a href='http://tas.klamstwo.org' target='_blank'>tas.klamstwo.org</a></p>");
}
elseif(isset($foto)) {
    //wy¶wietlenie zdjêcia
    echo "<b>$title</b>&nbsp;&nbsp;&nbsp;&nbsp;<small><a href='?$param'>Powrót do spisu</a></small><BR><BR><BR>";
        $OpenDir=opendir("./");
    $i=0;
    while (($katalog = readdir($OpenDir))!=false) {
        if(($katalog!=".")&&($katalog!="..")&&(!is_dir($katalog)) &&(substr($katalog,-4)==".jpg")||(substr($katalog,-4)==".JPG")) {
        		$i++;
            echo("<a href='?foto=$katalog&$param'>$i</a>&nbsp; ");
            if(($foto)!=$katalog) {
                if(!isset($next)) $next=$katalog;
                if($p==0) $prev=$katalog;
                if($oki==0) {
                    $prev=$katalog;
                    $p=1;
                }
                if($oki==1) {
                    $next=$katalog;
                    $oki=2;
                }
            }
            else {
                $oki=1;
            }
        }
    }
    echo "<br><BR><BR>";
    if(file_exists($foto)){
	    echo("<table border=0><tr><td align=center valign=middle> <a href='?foto=$prev'><<</a> </td><td><img src='$foto'></td><td align=center valign=middle> <a href='?foto=$next'>>></a>  </td></tr></table><BR><p class=small align=left>tFotoView by tas - <a href='http://tas.klamstwo.org' target='_blank'>tas.klamstwo.org</a></p>");
	}
}
?>
</td></tr></table>
</BODY>
</HTML>
<?PHP
	ob_end_flush();
?>