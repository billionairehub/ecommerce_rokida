<!DOCTYPE html>
<html>
<head>
<style>

table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 60%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
 
td {
  border: none;
}
.table_data {
    width:50%;
    float:right;
    /* margin-top:-25%; */
}
.table_img {
    width:50%;
    float:left;
}
</style>
</head>
<body style= "max-width: 650px; margin: auto;">
<h4> 
  Xin chào {{$users->first_name}}{{$users->last_name}},
</h4>
<h4>
  Đơn hàng {{$order->order_code}} của bạn đã được xác nhận ngày {{$order->created_at}} đã được vận chuyển<br>
  Vui lòng đăng nhập Shopee để xác nhận bạn đã nhận hàng và hài lòng với sản phẩm trong vòng 3 ngày. Sau khi bạn xác nhận, chúng tôi sẽ thanh toán cho Người bán .
  Nếu bạn không xác nhận trong khoảng thời gian này, Shopee cũng sẽ thanh toán cho Người bán.
</h4>
<hr>
<h2>THÔNG TIN ĐƠN HÀNG - DÀNH CHO NGƯỜI MUA</h2>
<table >
  <tr>
    <td> Mã đơn hàng:</td>
    <td> <b>{{$order->order_code}}</b> </td>
  </tr>
  <tr>
    <td>Ngày đặt hàng:</td>
    <td>{{$order->created_at}}</td>
  </tr>
</table>
<br>
<br>
@foreach($order_detail as $key => $value)
<table>
<tr>
    <table class="table_img">
        <tr>
        <?php
        $src = $value['image'];
        ?>
            <td>
            <img style="height: 55%;width: 90%;" src="https://ci4.googleusercontent.com/proxy/jkZqr_ZB0-oIc0C8vzAt-5M4pJD75qPVNaEUnAZJ03tXQjbyONY6-Y-fTjwpC-lywvKpVbln6dWXlNHBHg-OJyt2_mEJkckhlxvLZbO7Lss=s0-d-e1-ft#https://cf.shopee.vn/file/8fc9942669f33627c071847fe8ad6be2_tn" >
            </td>
        </tr>
    </table>
    <table class="table_data">
        <tr>
            <td>Người bán:</td>
            <td><b>{{$value['shop_name']}}</b></td>
        </tr>
        <tr>
            <td>Tên Sản phẩm</td>
            <td>{{$value['name']}}</td>
        </tr>
        <tr>
            <td>Số lượng </td>
            <td>{{$value['quantity']}}</td>
        </tr>
        <tr>
            <td>Giá</td>
            <?php
            if($value['promotion_price'] != 0)
            $dom = $value['promotion_price'];
            else
            $dom = $value['price'];
            ?>
            <td>VND {!! $dom !!}</td>
        </tr>
        <tr>
        <td>Tổng tiền: </td>
        <?php
            if($value['promotion_price'] != 0)
            $dom = $value['promotion_price'] * $value['quantity'];
            else
            $dom = $value['price'] * $value['quantity'];
            ?>
        <td>VND {!! $dom !!}</td>
        </tr>
    </table>
</tr>
</table>
@endforeach
<br>
<table style="width: 350px">
  <tr>
    <td>Phí vận chuyển: </td>
    <td>VND {{$order->fees_ship}}</td>
  </tr>
  <tr>
    <td>Tổng thanh toán: </td>
    <td>VND {{$order->total_bill}}</td>
  </tr>
</table>

</body>
</html>
