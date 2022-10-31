import App from '@/components/font_end/app'
import Redirect from '@/components/font_end/content/Redirect'
import Home from '@/components/font_end/content/Home'
import Introduce from '@/components/font_end/content/Introduce'
import Men_clock from '@/components/font_end/content/Men_clock'
import Women_clock from '@/components/font_end/content/Women_clock'
import News_clock from '@/components/font_end/content/News_clock'
import Contact from '@/components/font_end/content/Contact'
import Login from '@/components/font_end/content/Login'
import Cart from '@/components/font_end/content/Cart'
import User from '@/components/font_end/content/User'
import UserInformation from '@/components/font_end/content/UserInformation'
import Product_Details from '@/components/font_end/content/ProductDetails'
import Oder from '@/components/font_end/content/Oder'
import UserOrder from '@/components/font_end/content/User_order'
import ContentNews from '@/components/font_end/content/ContentNews'
import AllProduct from '@/components/font_end/content/All_product'
import Regester from '@/components/font_end/content/Regester'
import ShearchProduct from '@/components/font_end/content/Shearch_product'

import Notfound from '@/components/Notfound'
//admin
import Admin_login from '@/components/back_end/Admin_login'
import App_admin from '@/components/back_end/app'
import Overview from '@/components/back_end/contents/Overview'
import Product from '@/components/back_end/contents/Product'
import Order from '@/components/back_end/contents/Order'
import Slide from '@/components/back_end/contents/Slider'
import ManageNews from '@/components/back_end/contents/Manage_news'


const routes = [{ 
  path:'/', 
  component: Redirect 
  },
  { path:'/Home', 
    component:App,
    children: [{
      path:'',
      component:Home,
      name:'home'
    }]
  },
  { path:'/Home', 
    component:App,
    children: [{
      path:'/Introduce',
      component:Introduce
    }]
  },  
  { path:'/Home', 
    component:App,
    children: [{
      path:'/Men-clock',
      component:Men_clock,
      name:'men'
    }]
  }, 
  { path:'/Home', 
    component:App,
    children: [{
      path:'/Women-clock',
      component:Women_clock,
      name:'women'
    }]
  }, 
  { path:'/Home', 
    component:App,
    children: [{
      path:'/News-clock',
      component:News_clock,
      name:'news'
    }]
  },
  { path:'/Home', 
  component:App,
  children: [{
    path:'/Contact',
    component:Contact,
    name:'contact'
    }]
  },
  { path:'/Home', 
  component:App,
  children: [{
    path:'/Login',
    component:Login,
    name:'login'
    }]
  }, 
  { path:'/Home', 
  component:App,
  children: [{
    path:'/Cart',
    component:Cart,
    name:'cart'
    }]
  },
  { path:'/Home', 
  component:App,
  children: [{
    path:'/User',
    component:User,
    name:'user'
    }]
  }, 
  { path:'/Home', 
  component:App,
  children: [{
    path:'/UserInformation',
    component:UserInformation,
    name:'userinformation'
    }]
  },
  { path:'/Home', 
  component:App,
  children: [{
    path:'/product-details/:id',
    component:Product_Details,
    name:'productdetails'
    }]
  },
  { path:'/Home', 
  component:App,
  children: [{
    path:'/oders',
    component:Oder,
    name:'oder'
    }]
  },
  { path:'/Home', 
  component:App,
  children: [{
    path:'/User-order',
    component:UserOrder,
    name:'userorder'
    }]
  }, 
  { path:'/Home', 
  component:App,
  children: [{
    path:'/Content-news/:id_news',
    component:ContentNews,
    name:'contentnews'
    }]
  },
  { path:'/Home', 
  component:App,
  children: [{
    path:'/all-product',
    component:AllProduct,
    name:'allproduct'
  }]
  },
  { path:'/Home', 
  component:App,
  children: [{
    path:'/regester',
    component:Regester,
    name:'regester'
  }]
  },
  { path:'/Home', 
  component:App,
  children: [{
    path:'/Shearch-product',
    component:ShearchProduct,
    name:'Shearch',
    props: route =>({name: route.query.text}),
    // props: route => ({ name: route.query.name })
  }]
  },
  //admin
  { 
    path:'/admin', 
    component:Admin_login,
    name:'login_admin' 
  },
  {
    path:'/management',
    component:App_admin,
    children:[{
      path:'',
      component:Overview,
      name:'management',
    }]
  },
  {
    path:'/management',
    component:App_admin,
    children:[{
      path:'/product',
      component:Product,
      name:'Product-management',
    }]
  },
  {
    path:'/management',
    component:App_admin,
    children:[{
      path:'/Oder',
      component:Order,
      name:'Oder-management',
    }]
  },
  {
    path:'/management',
    component:App_admin,
    children:[{
      path:'/Admin-slide',
      component:Slide,
      name:'admin-slide',
    }]
  },
  {
    path:'/management',
    component:App_admin,
    children:[{
      path:'/manage-news',
      component:ManageNews,
      name:'manage-news',
    }]
  },
    //Notfound error
    { path:'/:pathMatch(.*)*', 
    component:Notfound,
    name:'Not_found'
    },
]

export default routes