<template>
<footer id="dk-footer" class="dk-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-4">
                    <div class="dk-footer-box-info">
                        <a href="" class="footer-logo">
                            <img src="@/assets/logo/footer.jpg" alt="footer_logo" class="img-fluid">
                        </a>
                        <p class="footer-info-text">
                          Trang web thực hiện về đồng hồ do sinh viên Nguyễn Minh Hưng Lớp 19i2 - MSV: 191c900079 thực hiện
                        </p>
                        <div class="footer-social-link">
                            <h3>Follow us</h3>
                            <ul>
                                <li>
                                    <a style="text-decoration: none;" href="#">
                                       <i class="fab fa-facebook fa-2x" style="color:#1804c9;cursor: pointer;background: white;"></i>
                                    </a>
                                </li>
                                <li>
                                    <a style="text-decoration: none;" href="#">
                                       <i class="fab fa-google-plus-g fa-2x" style="color:#f16919;cursor: pointer;background: white;"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- End Social link -->
                    </div>
                </div>
                <!-- End Col -->
                <div class="col-md-12 col-lg-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="contact-us">
                                <!-- End contact Icon -->
                                <div class="contact-info">
                                    <h3>PATEK PHILIPPE</h3>
                                </div>
                                <!-- End Contact Info -->
                            </div>
                            <!-- End Contact Us -->
                        </div>
                        <!-- End Col -->
                        <div class="col-md-6">
                            <div class="contact-us contact-us-last">
                                <div class="contact-icon">
                                    <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                                </div>
                                <!-- End contact Icon -->
                                <div class="contact-info">
                                    <h3>0934905720</h3>
                                    <p>Gọi cho chúng tôi</p>
                                </div>
                                <!-- End Contact Info -->
                            </div>
                            <!-- End Contact Us -->
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Contact Row -->
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="footer-widget footer-left-widget">
                                <div class="section-heading">
                                    <h3>Liên kết</h3>
                                </div>
                                <ul>
                                    <li>
                                        <a href="#">Contact us</a>
                                    </li>
                                    <li>
                                        <a href="#">Blog</a>
                                    </li>
                                    <li>
                                        <a href="#">Testimonials</a>
                                    </li>
                                    <li>
                                        <a href="#">Faq</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- End Footer Widget -->
                        </div>
                        <!-- End col -->
                        <div class="col-md-12 col-lg-6">
                            <div class="footer-widget">
                                <div class="section-heading">
                                    <h3>Thông tin liên hệ</h3>
                                </div>
                                <p>
                                    Trường Đại học công nghệ thông tin và truyền thông Việt Hàn
                                </p>
                                <form action="#">
                                    <div class="form-row">
                                        <div class="col dk-footer-form">
                                            <input type="email" class="form-control" placeholder="Email Address">
                                            <button type="submit">
                                                <i class="far fa-paper-plane"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <!-- End form -->
                            </div>
                            <!-- End footer widget -->
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>
                <!-- End Col -->
            </div>
            <!-- End Widget Row -->
        </div>
        <!-- End Contact Container -->
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <span>@2021 THỰC HIỆN BỞI NGUYỄN MINH HƯNG - THAM KHẢO MONA MEDIA</span>
                    </div>
                    <!-- End Col -->
                    <div class="col-md-6">
                        <div class="copyright-menu">
                            <ul>
                                <li>
                                    <a href="#">Trang chủ </a>
                                </li>
                                <li>
                                    <a href="#">Lien hệ</a>
                                </li>
                                <li>
                                    <a href="#">Sản phẩm</a>
                                </li>
                                <li>
                                    <a href="#">Tin tức</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End Row -->
            </div>
            <!-- End Copyright Container -->
        </div>
        <!-- End Copyright -->
        <!-- Back to top -->
        <div @click="BackToTop()" ref="buttonTop" class="back-to-top">
            <button class="btn btn-dark" title="Back to Top" style="display: block;">
                <i class="fa fa-angle-up"></i>
            </button>
        </div>
        <!-- End Back to top -->
</footer>

</template>

<script>
export default {
    data() {
      return {
      }
    },
    methods:{
      BackToTop(){
        window.scrollTo({top:0, behavior:'smooth'})
      }
    },
    mounted(){
      window.addEventListener('scroll' , ()=>{
        if(window.scrollY > 500){
          this.$refs.buttonTop.style.opacity = 1
        }
        else{
          this.$refs.buttonTop.style.opacity = 0
        }
        // window.scrollX > 500 ? this.$refs.buttonTop.style.opacity = 1 : this.$refs.buttonTop.style.opacity = 0
      })
    }
}
</script>

<style scoped>
 body { color: #ccc }
.footer-widget p {
    margin-bottom: 27px;
    color: rgb(153, 151, 151);
}
p {
font-family: 'Nunito', sans-serif;
font-size: 16px;
line-height: 28px;
}
.footer-logo>img{
  max-width: 100px;
}
.dk-footer {
  padding: 75px 0 0;
  background-color: #151414;
  position: relative; }
  .dk-footer .contact-us {
    margin-top: 0;
    margin-bottom: 30px;
    padding-left: 80px; }
    .dk-footer .contact-us.contact-us-last {
      margin-left: -80px; }
  .dk-footer .contact-icon i {
    font-size: 24px;
    top: -15px;
    position: relative;
    color:#007bff; }

.dk-footer-box-info {
  background: #202020;
  color: white;
  padding: 40px;
}
.dk-footer-box-info .footer-social-link h3 {
color: #fff;
font-size: 24px;
margin-bottom: 25px; }
.dk-footer-box-info .footer-social-link ul {
list-style-type: none;
padding: 0;
margin: 0; }
.dk-footer-box-info .footer-social-link li {
display: inline-block; }
.dk-footer-box-info .footer-social-link a i {
display: block;
width: 40px;
height: 40px;
border-radius: 50%;
text-align: center;
line-height: 40px;
background: #000;
margin-right: 5px;
color: #fff; }
.dk-footer-box-info .footer-social-link a i.fa-facebook {
    background-color: #3B5998; }
.dk-footer-box-info .footer-social-link a i.fa-twitter {
    background-color: #55ACEE; }
.dk-footer-box-info .footer-social-link a i.fa-google-plus {
    background-color: #DD4B39; }
.dk-footer-box-info .footer-social-link a i.fa-linkedin {
    background-color: #0976B4; }
.dk-footer-box-info .footer-social-link a i.fa-instagram {
    background-color: #B7242A; }
.footer-info-text {
  margin: 26px 0 32px; }

.footer-left-widget {
  padding-left: 80px; }

.footer-widget .section-heading {
  margin-bottom: 35px; }

.footer-widget h3 {
  font-size: 24px;
  color: #fff;
  position: relative;
  margin-bottom: 15px;
  max-width: -webkit-fit-content;
  max-width: -moz-fit-content;
  max-width: fit-content; }

.footer-widget ul {
  width: 50%;
  float: left;
  list-style: none;
  margin: 0;
  padding: 0; }

.footer-widget li {
  margin-bottom: 18px; }

.footer-widget p {
  margin-bottom: 27px; }

.footer-widget a {
  color: #878787;
  -webkit-transition: all 0.3s;
  -o-transition: all 0.3s;
  transition: all 0.3s; }
  .footer-widget a:hover {
    color: #007bff; }

.footer-widget:after {
  content: "";
  display: block;
  clear: both; }

.dk-footer-form {
  position: relative; }
  .dk-footer-form input[type=email] {
    padding: 14px 28px;
    border-radius: 50px;
    background: #2E2E2E;
    border: 1px solid #2E2E2E; }
  .dk-footer-form input::-webkit-input-placeholder, .dk-footer-form input::-moz-placeholder, .dk-footer-form input:-ms-input-placeholder, .dk-footer-form input::-ms-input-placeholder, .dk-footer-form input::-webkit-input-placeholder {
    color: #878787;
    font-size: 14px; }
  .dk-footer-form input::-webkit-input-placeholder, .dk-footer-form input::-moz-placeholder, .dk-footer-form input:-ms-input-placeholder, .dk-footer-form input::-ms-input-placeholder, .dk-footer-form input::placeholder {
    color: #878787;
    font-size: 14px; }
  .dk-footer-form button[type=submit] {
    position: absolute;
    top: 0;
    right: 0;
    padding: 7px 20px 7px 16px;
    border-top-right-radius: 25px;
    border-bottom-right-radius: 25px;
    border:none;
    background: #007bff;
    color: #fff; }
  .dk-footer-form button:hover {
    cursor: pointer; }

/* ==========================

    Contact

=============================*/
.contact-us {
  position: relative;
  margin-top: 65px;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -webkit-align-items: center;
  -moz-box-align: center;
  -ms-flex-align: center;
  align-items: center; }

.contact-icon {
  position: absolute; }
  .contact-icon i {
    font-size: 36px;
    top: -5px;
    position: relative;
    color: #007bff; }

.contact-info {
  color: #fff; }
  .contact-info h3 {
    font-size: 20px;
    color: #fff;
    margin-bottom: 0; }

.copyright {
  padding: 28px 0;
  margin-top: 55px;
  background-color: #202020; }
  .copyright span,
  .copyright a {
    color: #878787;
    -webkit-transition: all 0.3s linear;
    -o-transition: all 0.3s linear;
    transition: all 0.3s linear; }
  .copyright a:hover {
    color:#007bff; }

.copyright-menu ul {
  text-align: right;
  margin: 0; }

.copyright-menu li {
  display: inline-block;
  padding-left: 20px; }

.back-to-top {
  opacity: 0;
  transition: opacity 0.6s;
  position: relative; }
  .back-to-top .btn-dark {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    padding: 0;
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #2e2e2e;
    border-color: #2e2e2e;
    display: none;
    -webkit-transition: all 0.3s linear;
    -o-transition: all 0.3s linear;
    transition: all 0.3s linear; }
    .back-to-top .btn-dark:hover {
      cursor: pointer;
      background: #fcc81f;
      border-color: #fcc81f; }

</style>