<template>
    <div class="footer">
        <div class="flex_footer">
            <ul>
                <li>Về chúng tôi</li>
                <li>Liên hệ</li>
                <li>Giấy phép</li>
            </ul>
        </div>
        <div class="flex_footer">
            <p>@2021 thực hiện bởi nguyễn minh hưng</p>
        </div>
    </div>
</template>

<style scoped>
.footer{
    display: flex;
    background: rgb(236, 234, 234);
    border-top:1px solid rgb(156, 156, 156);
    color: rgb(117, 116, 116);
    text-align: center;
    text-transform: uppercase;

}
.footer>div{
    width: 50%;
    margin: 20px;
}
.flex_footer>ul>li{
    list-style: none;
    float: left;
    padding: 0 20px 0 20px;
}
</style>