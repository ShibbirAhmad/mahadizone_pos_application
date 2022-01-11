<template>
  <div class="wrapper-wide">
    <frontend-header></frontend-header>
    <div class="row slider_row">
      <div class="slider_container">
        <carousel
          v-if="sliders"
          :items="1"
          :nav="false"
          :autoplay="true"
          :autoplayTimeout="4000"
        >
          <a v-for="slider in sliders" :href="slider.url" :key="slider.id">
            <img class="landing_slider_img" :src="base_url + slider.image" />
          </a>
        </carousel>
      </div>
    </div>


     <div class="row">
        <div class="mens_womens_collection_container">
        <div
          v-if="banners['mens_collection']"
          class="banner_content"
        >
          <a
            v-if="banners['mens_collection'].status == 1"
            target="_blank"
            :href="banners['mens_collection'].url"
          >
            <img  :src="this.base_url + banners['mens_collection'].banner" />
          </a>
        </div>
        <div
          v-if="banners['womens_collection']"
           class="banner_content"
        >
          <a
            v-if="banners['womens_collection'].status == 1"
            target="_blank"
            :href="banners['womens_collection'].url"
          >
            <img :src="this.base_url + banners['womens_collection'].banner" />
          </a>
        </div>
      </div>
      </div>

      <ParallaxBanner />


    <div class="container">

      <div v-if="shop_with_categories['mens']" class="row shop_by_category_row">
        <div class="col-lg-12 col-md-12 col-xs-12 margin_container text-center">
          <img
            :src="base_url + '/images/basic_img/MARGIN-DESIGN.png'"
            class="margin_design"
          />
          <h4 class="section_title">Shop By Category For Men's</h4>
        </div>
        <div
          v-if="banners['new_arrival']"
          class="
            col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-6
            shop_by_category_container
          "
        >
          <div class="content">

            <router-link v-if="banners['new_arrival'].status==1" :to="{ name: 'new_arrival_products',params:{slug:'1008-Fashion'} }">
              <img :src="this.base_url + banners['new_arrival'].banner" />
            </router-link>
          </div>
          <div class="content_footer text-center">
            <router-link class="sub_c_name" :to="{ name: 'new_arrival_products',param:{slug:shop_with_categories['mens']} }">
              New Arrival
              <span class="sub_category_angle"
                ><i
                  aria-hidden="true"
                  class="fa fa-lg fa-angle-double-right"
                ></i></span
            ></router-link>
          </div>
        </div>

        <div
          v-for="(sub_c, sub_c_index) in shop_with_categories['mens']"
          :key="sub_c_index"
          class="
            col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-6
            shop_by_category_container
          "
        >
          <div class="content">
            <router-link
              :to="{ name: 'PublicSubCategory', params: { slug: sub_c.slug } }"
            >
              <img :src="base_url + sub_c.image" :alt="sub_c.name" />
            </router-link>
          </div>
          <div class="content_footer text-center">
            <router-link
              class="sub_c_name"
              :to="{ name: 'PublicSubCategory', params: { slug: sub_c.slug } }"
            >
              {{ sub_c.name.substring(0,12) }}<span v-if="sub_c.name.length>12" >...</span>
              <span class="sub_category_angle"
                ><i
                  aria-hidden="true"
                  class="fa fa-lg fa-angle-double-right"
                ></i></span
            ></router-link>
          </div>
        </div>
      </div>

      <div v-if="shop_with_categories['womens'] && banners['womens_collection'].status==1" class="row shop_by_category_row">
        <div class="col-lg-12 col-md-12 col-xs-12 margin_container text-center">
          <img
            :src="base_url + '/images/basic_img/MARGIN-DESIGN.png'"
            class="margin_design"
          />
          <h4 class="section_title">Shop By Category For WoMen's</h4>
        </div>
        <div
          v-if="banners['new_arrival']"
          class="
            col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-6
            shop_by_category_container
          "
        >
          <div class="content">
               <router-link v-if="banners['new_arrival'].status==1" :to="{ name: 'new_arrival_products',params:{slug:'1000-Fashion'} }">
              <img :src="this.base_url + banners['new_arrival'].banner" />
               </router-link>
          </div>
          <div class="content_footer text-center">
            <router-link class="sub_c_name" :to="{ name: 'PublicSubCategory' }">
              New Arrival
              <span class="sub_category_angle"
                ><i
                  aria-hidden="true"
                  class="fa fa-lg fa-angle-double-right"
                ></i></span
            ></router-link>
          </div>
        </div>

        <div
          v-for="(sub_c, sub_c_index) in shop_with_categories['womens']"
          :key="sub_c_index"
          class="
            col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-6
            shop_by_category_container
          "
        >
          <div class="content">
            <router-link
              :to="{ name: 'PublicSubCategory', params: { slug: sub_c.slug } }"
            >
              <img :src="base_url + sub_c.image" :alt="sub_c.name" />
            </router-link>
          </div>
          <div class="content_footer text-center">
            <router-link
              class="sub_c_name"
              :to="{ name: 'PublicSubCategory', params: { slug: sub_c.slug } }"
            >
              {{ sub_c.name.substring(0,12) }}<span v-if="sub_c.name.length>12" >...</span>
              <span class="sub_category_angle"
                ><i
                  aria-hidden="true"
                  class="fa fa-lg fa-angle-double-right"
                ></i></span
            ></router-link>
          </div>
        </div>
      </div>



      <div class="new_arrival_section">
        <div class="row new_product_row">
          <div class="col-lg-12 col-md-12 col-xs-12 text-center">
            <img
              :src="base_url + '/images/basic_img/MARGIN-DESIGN.png'"
              class="margin_design"
            />
            <h4 class="section_title">What's New On Mahadizone</h4>
          </div>

          <NewProductsHorizontalSlide />
        </div>

        <img v-if="banners['top_selling'].status ==1"
          class="top_selling_banner"
          :src="base_url + banners['top_selling'].banner"
        />

        <TopSellingProducts />
      </div>

      <div>
        <SessionalAndOccationalCampaign />
      </div>




      <div class="row suggetion_product_row">
        <div class="col-lg-12 col-md-12 col-xs-12 margin_container text-center">
          <img
            :src="base_url + '/images/basic_img/MARGIN-DESIGN.png'"
            class="margin_design"
          />
          <h4 class="section_title">You May Like</h4>
        </div>

        <SuggestProducts />
      </div>

      <div class="row service_row">
        <div class="col-md-3 col-sm-6 text-center">
          <div class="service_container">
            <div class="service_outer">
              <div class="service_inner">
                <i class="fa fa-thumbs-up service_icon"> </i>
              </div>
            </div>
            <h4>High-quality Goods</h4>
            <p>Enjoy top quality items for less</p>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 text-center">
          <div class="service_container">
            <div class="service_outer">
              <div class="service_inner">
                <i class="fa fa-headphones service_icon"> </i>
              </div>
            </div>
            <h4>24/7 Livechat</h4>
            <p>Get instant assistance whenever you need it</p>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 text-center">
          <div class="service_container">
            <div class="service_outer">
              <div class="service_inner">
                <i class="fa fa-truck service_icon"> </i>
              </div>
            </div>
            <h4>Express Shipping</h4>
            <p>Fast & reliable delivery options</p>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 text-center">
          <div class="service_container">
            <div class="service_outer">
              <div class="service_inner">
                <i class="fa fa-credit-card service_icon"> </i>
              </div>
            </div>
            <h4>Secure Payment</h4>
            <p>Multiple safe payment methods</p>
          </div>
        </div>
      </div>
    </div>

    <frontend-footer></frontend-footer>
    <quick-view
      v-if="quick_v_product_id"
      v-on:clicked="closedModal($event)"
      :quick_v_p_id="quick_v_product_id"
    >
    </quick-view>
  </div>
</template>

<script>
import Vue from "vue";

import FlipCountdown from "vue2-flip-countdown";
import carousel from "vue-owl-carousel";
import TopSellingProducts from "../public/partials/TopSellingProducts";
import SuggestProducts from "../public/partials/SuggestedProducts";
import ParallaxBanner from "../public/partials/ParallaxBanner";
import NewProductsHorizontalSlide from "../public/partials/NewProductsHorizontalSlide";
import SessionalAndOccationalCampaign from "../public/partials/SessionalAndOccationalCampaign";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
Vue.use(Loading);

export default {
  mounted() {
    window.scrollTo(0, 0);
  },
  created() {
    this.$store.dispatch("categories");
    this.$store.dispatch("sliders");
    this.$store.dispatch("banners");
  },
  components: {
    Loading,
    carousel,
    FlipCountdown,
    TopSellingProducts,
    SuggestProducts,
    SessionalAndOccationalCampaign,
    ParallaxBanner,
    NewProductsHorizontalSlide,
  },

  data() {
    return {
      loading: true,
      page: 1,
      product_id: null,
      base_url: this.$store.state.image_base_link,
      isScroll: 0,
      quick_v_product_id: "",
      o_modal: false,
      suggested_products: "",
    };
  },
  methods: {
    productDetals(product_id) {
      this.prdoct_modal = true;
      this.product_id = product_id;
    },

    closedModal(close) {
      this.quick_v_product_id = "";
    },
    showCategoryName(id) {
      var x = document.getElementById("subCategoryNameView" + id);
      x.classList.toggle("displayeBlok");
    },
  },

  computed: {
    categories() {
      return this.$store.getters.categories;
    },
    banners() {
      return this.$store.getters.banners;
    },

    sliders() {
      return this.$store.getters.sliders;
    },

    shop_with_categories() {
      return this.$store.getters.shop_with_categories;
    },
  },
};

//show sub  menu in mobile menu
document.addEventListener("DOMContentLoaded", () => {
  //set a time our function. this function call after 2 sec on domloaded
  setTimeout(() => {
    //find the click element
    let sub_menu = document.getElementsByClassName("show-sub");

    for (let i = 0; i < sub_menu.length; i++) {
      //set a click event
      sub_menu[i].addEventListener("click", function () {
        let show_sub_menu =
          sub_menu[i].parentElement.querySelector(".left-sub-menu");
        //set active class
        show_sub_menu.classList.toggle("nav-active");
        sub_menu[i].classList.toggle("fa-minus");
      });
    }
  }, 2000);
});
</script>


