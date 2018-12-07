<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="initial-scale=1.0"/> <!-- So that mobile webkit will display zoomed in -->
        <meta name="format-detection" content="telephone=no"/> <!-- disable auto telephone linking in iOS -->
        <style type="text/css">
            /* Resets: see reset.css for details */
            .ReadMsgBody { width: 100%; background-color: #ebebeb;}
            .ExternalClass {width: 100%; background-color: #ebebeb;}
            .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100%;}
            body {margin:0; padding:0;-webkit-text-size-adjust:none; -ms-text-size-adjust:none;}
            table {border-spacing:0;}
            table td {border-collapse:collapse;}
            .yshortcuts a {border-bottom: none !important;}
            /* Constrain email width for small screens */
            @media screen and (max-width: 600px) {
                table[class="container"] {
                    max-width: 95% !important;
                }
                .responsive-image img {
                    height: auto !important; max-width:100% !important;
                }
            }

            /* Give content more room on mobile */
            @media screen and (max-width: 480px) {
                td[class="container-padding"] {
                    padding-left: 12px !important;
                    padding-right: 12px !important;
                }
            }
            @media only screen and (max-width: 480px) {
                body,table,td,p,a,li,blockquote {
                    -webkit-text-size-adjust:none !important;
                }
                table {max-width:95%!important;}
                body{font-size:50%!important}
                .img-responsive{ 
                    height: auto !important; max-width:45% !important
                }
            }
            img {
                outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;
            }
            a img {border:none;}
            .image_fix {display:block;}

            /* Yahoo paragraph fix
            Bring inline: Yes. */
            p {margin: .8em 0;}
            table { mso-table-lspace:0pt; mso-table-rspace:0pt; }
            h1{font-size: 36px}
            h2{font-size: 28px}
            h3{font-size: 24px}
            h4{font-size: 22px}
            h5{font-size: 18px}
            h6{font-size: 14px}
        </style>
        <title>Order Placed Successfully</title>
    </head>
    <body marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" style="margin:0; padding:0;">
        <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="border-collapse: separate;background-color:#efefef;color:#555555;" >
            <tbody>
                <tr>
                    <td width="100%" style="padding-top:30px;padding-right:0;padding-bottom:20px;padding-left:0;margin:0;">
                        <table cellspacing="0" cellpadding="0" border="0" align="center" width="700" >
                            <tr>
                                <td align="left" valign="middle"><a href="" style="text-decoration:none;"><img src="http://bentokitchen.in/images/logo/2/2.png" style="width: auto;height: 80px;"/></a></td>
                            </tr>
                        </table>
                        <table cellspacing="0" cellpadding="0" border="0" align="center" width="700" style="box-shadow:0 1px 1px 0 rgba(0, 0, 0, 0.1);" >
                            <tbody>
                                <tr>
                                    <td align="left" style="background-color:#ffffff;color:#555555;">
                                        <!--<img src="http://goqii.com/webApp/images/template-images/icon3.png" width="100%"/>-->
                                        <div style="padding:15px;color:#555555;font-weight:normal;font-size:12px;font-family:Helvetica,Arial,sans-serif;line-height:20px;padding-bottom: 20px;">
                                        <table cellspacing="0" cellpadding="15" border="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p style="line-height:1.5;font-size: 14px" ><b>Hello {{$order['users']['name']}},</b></p>
                                                        <p style="line-height: 1.5;font-size: 12px">Your {{$order['order_type']['name']}} order dated {{date('jS M Y',strtotime($order['order_date']))}} is successfully placed.</p>
                                                        <br/>
                                                        <p style="line-height: 1.5;font-size: 12px">Order Total Amount -  {{$order['total_amount']}}</p>
                                                        <p style="line-height: 1.5;font-size: 12px">
                                                            @if (is_array($order['orderDishes']))
                                                                <p style="line-height: 1.5;font-size: 12px">Below is the summary of your order:- </p>
                                                                @foreach($order['orderDishes'] as $orderItems)
                                                                    <p style="line-height: 1.5;font-size: 12px">{{$orderItems['quantity']}} {{$orderItems['dishName']}} - {{$orderItems['totalPrice']}}</p>
                                                                @endforeach
                                                            @endif
                                                        </p>
                                                        <p style="line-height: 1.5;font-size: 12px"><b>Thank You,</b></p>   
                                                        <p style="line-height: 1.0;font-size: 12px"><b>Team Bento</b></p>              
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>                              
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>