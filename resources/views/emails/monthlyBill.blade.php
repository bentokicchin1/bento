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
        <title>Bill For the month of {{$lastMonth}}</title>
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
                                                        <p style="line-height:1.5;font-size: 14px" ><b>Hello {{ $user['name'] }},</b></p>
                                                        <br/>
                                                        <p style="line-height: 1.5;font-size: 13px">Below is the summary of orders for the month of {{$lastMonth}}.</p>
                                                        <table cellspacing="5" cellpadding="5" border="1" width="100%" align="center">
                                                          <thead>
                                                            <th>Date</th>
                                                            <th>Order Details</th>
                                                            <th>Price</th>
                                                          <thead>
                                                            <tbody>
                                                                @foreach($orders as $key=>$order_detail)
                                                                    <tr>
                                                                        <td>{{date('D,d F Y',strtotime($order_detail['order_date']))}}</td>
                                                                        <td>
                                                                            @if(!empty($order_detail['dishList']))
                                                                                @foreach($order_detail['dishList'] as $dishId=>$dish)
                                                                                    {{ $dish['quantity'].' '.$dish['dishName']. ' ' }}
                                                                                @endforeach
                                                                            @endif
                                                                        </td>
                                                                        <td>{{$order_detail['total_amount']}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        <br/>
                                                        <table cellspacing="20" cellpadding="25" border="0" width="100%" >
                                                            <tbody>
                                                                <tr><td style="width:20%;"></td><td style="width:20%;"></td>
                                                                    <td align="right" style="text-align: right;">
                                                                        <table align="right" cellspacing="10" cellpadding="10" style="background-color:#f7f7f7;border:solid 1px #e4e6eb;">
                                                                            <thead></thead>
                                                                            <tbody>
                                                                                <tr style="line-height: 1.5;font-size: 13px"><td><b>{{$lastMonth}} Bill Amount:-</b></td><td style="width:30%;">{{$billAmount}} Rs.</td><tr>
                                                                                <tr style="line-height: 1.5;font-size: 13px"><td><b>Pending Bill Amount:-</b></td><td style="width:30%;">{{$pendingBill}} Rs.</td></tr>
                                                                                <tr style="line-height: 1.5;font-size: 13px"><td><b>Total Bill Amount:-</b></td><td style="width:30%;">{{$outstanding_bill}} Rs.</td></tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <br/>
                                                        <p style="line-height: 1.0;font-size: 12px">Please visit <a href="http://bentokitchen.in/customer/orders">My Orders</a> page to check your order history.</p>
                                                        <p style="line-height: 1.0;font-size: 12px">We accept payments through mobile wallets(Paytm/PhonePe/Google Pay), account transfers and cash.</p>
                                                        <p style="line-height: 1.0;font-size: 12px">Contact on 9130002835 for getting transfer details.</p>
                                                        <br/>
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
