<?php
/* returns the shortened url */
function get_bitly_short_url($url,$login='XXXXXXXXXXXXXXX',$appkey='XXXXXXXXXXXXXXXXX',$format='txt') {
	$connectURL = 'http://api.bit.ly/v3/shorten?login='.$login.'&apiKey='.$appkey.'&uri='.urlencode(trim(preg_replace('/\s\s+/', ' ', $url))).'&format='.$format;
	return curl_get_result($connectURL);
}
/* returns a result form url */
function curl_get_result($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
?>

<html>
    <head>
        <title>Bulk bit.ly shorter</title>

        <!-- Including Bootstrap files for theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    <body>
        <div style="max-width:360px;margin-left: auto; margin-right: auto;">
            <center>
                <h1>Bulkbit.ly shporter</h1>
                <form action="index.php" method="POST">
                    <textarea name="url" placeholder="Type your URLs here, onre line each" class="form-control"></textarea>
                    <br/>
                    <input type="submit" value="Short All" class="btn btn-success"/>
                </form>
                <?php
                
                if( isset($_POST['url']) )
                {
                    $text = trim($_POST['url']);
                    $textAr = explode("\n", $text);
                    $textAr = array_filter($textAr, 'trim'); // remove any extra \r characters left behind
                    
                    echo '<br>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Short URL</th>
                                    <th>Long URL</th>
                                </tr>
                            <thead>
                            <tbody>';
                    
                    foreach ($textAr as $line)
                    {
                        echo '<tr>
                                <td>'.get_bitly_short_url($line).'</td>
                                <td>'.$line.'</td>
                            </tr>';
                    }
                    
                    echo '</tbody>
                    </table>';
                    
                }
                
                ?>
            </center>
        </div>
    </body>
</html>
