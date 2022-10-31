<template>
<div>
    <div class="title">
        <p> web đồng hồ patek philippe geneve</p>
    </div>
    <div class="overview">
        <div class="content">
            <div class="text_content">
                <span>Sản phẩm</span>
                <br>15
            </div>
            <div class="cart_title">
                Sản phẩm hiện có trên hệ thống:
                <br><span>Sản phẩm:15</span>
            </div>
        </div>
        <div class="content">
            <div class="text_content">
                <span>Tin tức</span>
                <br>6
            </div>
            <div class="cart_title">
                Bảng tin có trên hệ thống:
                <br><span>Số tin:6</span>
            </div>
        </div>
        <div class="content">
            <div class="text_content">
                <span>Đơn hàng</span>
                <br>11
            </div>
            <div class="cart_title">
                Tổng số đơn hàng:
                <span>Đã xử lý:10</span><br>
                <span>Chưa xử lý:1</span><br>
            </div>
        </div >
        <div class="content">
            <div class="text_content">
                <span>Doanh thu</span>
                <br>3000$
            </div>
            <div class="cart_title">
                Doanh thu của cửa hàng:<br>
                <span>Tổng doanh thu:30000$</span><br>
                <span>Trong tháng qua:3000$</span><br>
            </div>
        </div>
    </div>
    <div class="flex_overview">
        <div>

        </div>
        <div>

        </div>
    </div>    
</div>    
</template>

<script>
export default {
    
}
</script>

<style scoped>
.title{
    width: 100%;
    height: 100px;
    line-height: 100px;
    font-size: 20px;
    color:rgb(117, 116, 116);
    text-transform: uppercase;
    text-align: center;
    background: rgb(236, 234, 234);
}.overview{
    display: flex;
    background:rgb(236, 234, 234);
}
.overview>div{
    width: 25%;
    height: 200px;
    margin: 10px;
    background: white;
    box-shadow: 0 5px 6px rgb(99, 99, 99);
    font-size: 20px;
    border-radius: 10px;
}
.text_content{
    background: rgb(103, 209, 212);
    text-align: center;
    color: white;
    font-weight: bolder;
}
.cart_title{
    color:rgb(87, 87, 87);
    font-size: 18px;
    padding: 0 10px 10px 10px;
}.cart_title>span{
    font-size: 14px;
    color:rgb(117, 116, 116);
}
.flex_overview{
    display: flex;
    background:rgb(236, 234, 234);
}
.flex_overview>div{
    width: 50%;
    height: 500px;
    margin: 20px;
    border-radius: 10px;
    background:white;
}
</style>