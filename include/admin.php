<?php

if ( ! defined( 'ABSPATH' ) ) exit;
$submitted_value = $_REQUEST['_wpnonce'];

$path =  plugin_dir_path(__FILE__).'raccoon_apikey.php';
 /* start send apikey to apikey_file */

if (wp_verify_nonce( $submitted_value, 'submit_api_key' ) && isset($_POST['submit'])) {
    $text = sanitize_text_field($_POST['apikey']);
    if (!empty($text)){

        $var_str = var_export($text, true);
        $var = "<?php\n\n\$client_api = $var_str;\n\n?>";
        file_put_contents($path, $var);
        echo '<br>' . '<div style=" color: #721c24; background-color: #d4edda; border-color: #c3e6cb; position: relative; padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem; font-size: 16px; " role="alert">
           The Apikey sent successfully !
    </div>';
    }else {
        echo '<br>' . '<div style=" color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; position: relative; padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem; font-size: 16px; " role="alert">
          Please Write your Apikey !
    </div>';
    }
}
/* End send apikey to apikey file */

/* start send item_number to apikey file */

if (wp_verify_nonce( $submitted_value, 'submit_item_number' ) && isset($_POST['send'])) {
$item_number = sanitize_text_field($_POST['item_number']);
    $path_item =  plugin_dir_path(__FILE__).'item_number.php';

if (!empty($item_number)  && $item_number  > 0 && $item_number < 11){
    $var_num = var_export($item_number, true);

    $var_item = "<?php\n\n\$item_number = $var_num;\n\n?>";
    file_put_contents($path_item, $var_item);
    echo '<br>' . '<div style=" color: #721c24; background-color: #d4edda; border-color: #c3e6cb; position: relative; padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem; font-size: 16px; " role="alert">
           The Products Number sent successfully !
    </div>';
}else {
    echo '<br>' . '<div style=" color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; position: relative; padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem; font-size: 16px; " role="alert">
          Please Write your Products Number you need to View !
    </div>';
}
}
/* End send item_number to apikey file */
?>



<body style="background-color:black">
<h1 style="text-align: center; color: slategray; font-family:  Gabriola; font-size:xx-large">Welcome to Raccoon Platform Plugin on WooCommerce</h1>
<p style="font-family: cursive; font-size: large; color:darkgoldenrod;">Raccoon Act’s like a sales man at your E-commerce
    By analyzing users behavior and start recommending to your customer which leads to a great increase in your revenue and increase your customer experience offered with a Realtime analytics
</p>
<center>
<img src="<?php echo plugin_dir_url( __FILE__ ).'image_setting/raccoon_setting1.png'; ?>" width="420px" height="270px">
<img src="<?php echo plugin_dir_url( __FILE__ ).'image_setting/raccoon_setting2.png'; ?>"  width="420px" height="270px">
</center>

<h2 style="font-family: Constantia; color: ghostwhite" > How it works ? </h2>

<h3 style="font-family: Bahnschrift; color:rgb(181, 190, 174)">⦁	First please generate an Account from here
<a href="https://console.raccoonplatform.com/register" style="text-decoration: none; color: gray()" target=”_blank” >Raccoon Platform</a> </h3>
<h3 style="font-family: Bahnschrift; color:rgb(181, 190, 174)">⦁	Choose a plan </h3>
<img src="<?php echo plugin_dir_url( __FILE__ ).'image_setting/raccoon_setting3.png'; ?>" width="460px">

 <h3 style="font-family: Bahnschrift; color:rgb(181, 190, 174)">⦁	Activate your API Key</h3>
<img src="<?php echo plugin_dir_url( __FILE__ ).'image_setting/raccoon_setting4.png'; ?>" width="460px">
<br><br>
<div class="form-group">
    <form action="" method="post">
        <?php wp_nonce_field( 'submit_api_key' ); ?>
        <label style=" font-family: Bahnschrift; color:rgb(181, 190, 174); font-size: medium">⦁	Enter your API_Key Here : </label>
        <input type="text" name="apikey" >
        <button type="submit" class="btn btn-primary btn-sm-2" style="color: #fff;background-color: saddlebrown;border-color: #007bff;/* padding: 3px 17px; */font-weight: 400;text-align: center;white-space: nowrap;vertical-align: middle;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none; border: 1px solid transparent;padding: 0.175rem .75rem;font-size: 1rem;line-height: 1.5; border-radius: 20px;" name="submit">Send</button>
    </form>
</div>
<br>
<div class="form-group">
    <form action="" method="post">
        <?php wp_nonce_field( 'submit_item_number' ); ?>
        <label style=" font-family: Bahnschrift; color:rgb(181, 190, 174); font-size: medium">⦁	Write Number of Products you want  to view in your Store   : </label>
        <input type="number" name="item_number" max="10" min="1">
        <button type="submit" class="btn btn-primary btn-sm-2" style="color: #fff;background-color: saddlebrown;border-color: #007bff;/* padding: 3px 17px; */font-weight: 400;text-align: center;white-space: nowrap;vertical-align: middle;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none; border: 1px solid transparent;padding: 0.175rem .75rem;font-size: 1rem;line-height: 1.5; border-radius: 20px;" name="send">Send</button>
    </form>
</div>
<h3 style="font-family: Bahnschrift; color:rgb(181, 190, 174)">⦁	Learn how to add the short code from this video into your E-commerce</h3>

<center><iframe width="760" height="350" src="https://www.youtube.com/embed/esbDM_0raZo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></center>
<h3 style="font-family: Bahnschrift; color:rgb(181, 190, 174)">⦁ There are shortcodes you will use in your E-commerce </h3>

<table border = "1" cellpadding = "5" cellspacing = "5" style="color: black; background-color: darkkhaki">

    <tr>
        <th>Name of Request</th>
        <th>Shortcode </th>
    </tr>
    <tr>
        <td>Most views Items </td>
        <td>[popularView]</td>
    </tr>
    <tr>
        <td>Most Purchased Items</td>
        <td>[popularAtc]</td>
    </tr>
    <tr>
        <td>You Might Also Like </td>
        <td>[Recommended_Item]</td>
    </tr>
</table>

<h3 style="font-family: Bahnschrift; color:rgb(181, 190, 174)"> ⦁	Finally you can view your Realtime analytics from here
    <a href="https://console.raccoonplatform.com" style="text-decoration: none; color: gray()" target=”_blank”>Raccoon View</a></h3>

</body>





