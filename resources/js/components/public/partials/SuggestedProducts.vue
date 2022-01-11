<template>
  <div class="row">
    <div
      v-for="(product, index) in suggest_products"
      :key="index"
      class="
        col-xl-3 col-md-3 col-lg-3 col-sm-3 col-xs-6
        content_card_container
      "
    >
      <div class="content_card">
        <div class="content_card_body text-center">
          <router-link
            :to="{
              name: 'single',
              params: { slug: product.slug },
            }"
          >
            <img
              :src="base_url + product.thumbnail_img"
            />
          </router-link>
          <p class="content_link">
            <router-link
              :to="{
                name: 'single',
                params: { slug: product.slug },
              }"
              >{{ product.name }}</router-link
            >
          </p>
          <!-- <p class="price">
            <span class="price-new"> &#2547;{{ product.price }}</span>
            <span class="price-old" v-if="product.discount">
              &#2547;{{ product.sale_price }}</span
            >
          </p> -->
          <p class="price">
            <span class="price-new"> &#2547;{{ product.price }}</span>
            <span class="price-old" v-if="product.discount">
              &#2547;{{ product.sale_price }}</span
            >
            <span v-if="product.discount > 0" class="discount">
              <div class="star-icon" style="margin-top:-7px; margin-bottom: -32px">
                <i class="fa fa-star" aria-hidden="true"></i>
                <span style="margin-left:-3px">
                  <i class="fa fa-star" aria-hidden="true"></i>
                </span>
              </div>
              <div class="discount-item" style="margin-top: 6px;">
                {{ ((product.discount / product.sale_price) * 100).toFixed(0) }}%
                <span class="d_off">off</span>
              </div>
              
            </span>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  created() {
    this.$store.dispatch("suggest_products");
  },
  data() {
    return {
      base_url: this.$store.state.thumbnail_img_base_link,
    };
  },
  computed: {
    suggest_products() {
      return this.$store.getters.suggest_products;
    },
  },
};
</script>