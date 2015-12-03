<?PHP 
$link="http://m.apps.store.aptoide.com/app/market/org.videolan.vlc/1069205/13193348/VLC+for+Android";// aptoide link
include_once('../_includes/apk.php');
$apk=new apk($link);
echo $apk->get_apk();// fetches the apk file link
?>