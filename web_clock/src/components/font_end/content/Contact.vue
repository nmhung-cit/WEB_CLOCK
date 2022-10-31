<template>
    <div class="contact">
        <div class="contact-content">
            <div class="information-contact">
                <div class="information-contact-content">
                    <h1>LIÊN HỆ</h1>
                    <p class="title">This is an online watch selling website made by student <span>NGUYEN MINH HUNG</span></p>
                    <p>This website is a student graduation project, it is not practical. All content on the website is for reference only.</p>
                </div>
            </div>
            <div class="information">
                <div class="information-user-image"></div>
                <div class="information-user">
                    <div class="user-img">
                        <img class="image-user" src="@/assets/Hung.jpg" alt="">
                        <img class="image-tick-green" src="@/assets/tick-xanh.png" alt="">
                    </div>
                    <div class="user">
                        <h3 class="User-name">NGUYỄN MINH HƯNG</h3>
                        <h6>DEVELOPER</h6>
                        <div class="skill">
                            <h4>SKILL &lt;/&gt;</h4>
                            <table>
                                <tr>
                                    <th>FONTEND</th>
                                    <th>BACKEND</th>
                                </tr>
                                <tr>
                                    <td>HTML</td>
                                    <td>PHP(LARAVEL)</td>
                                </tr>
                                <tr>
                                    <td>CSS</td>
                                    <td>MYSQL</td>
                                </tr>
                                <tr><td>JAVASCRIPT(VUEJS)</td></tr>
                                <tr>
                                    <td colspan="2" class="button-hire-me">
                                        <button @click="Kick()" >HIRE ME</button>
                                        <a ref="linkface" style="display:none" href="https://www.facebook.com/nmhung.cit" target="_blank">link</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</template>

<script>
export default {
    methods:{
        Kick(){
            this.$refs.linkface.click()
        }
    }
}
</script>

<style scoped src = "@/assets/styles/frontend/Contact.css">
</style>