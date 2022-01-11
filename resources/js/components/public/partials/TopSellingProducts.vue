<template>
  <div class="row">
    <vue-horizontal-list
      :items="best_selling_produtcs"
      :options="best_selling_options"
    >
      <template v-slot:default="{ item }">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 item">
          <div class="new_arrival_container">
            <div class="new_arrival_card">
              <div class="new_arrival_card_body text-center">
                <router-link
                  :to="{
                    name: 'single',
                    params: { slug: item.slug },
                  }"
                >
                  <img
                   :src="base_url+item.thumbnail_img"
                  />
                </router-link>
                <p class="arrival_link">
                  <router-link
                    :to="{
                      name: 'single',
                      params: { slug: item.slug },
                    }"
                    >{{ item.name.substring(0, 20) }}
                    <span v-if="item.name.length > 20">...</span></router-link
                  >
                </p>
                <p class="price">
                  <span class="price-new"> &#2547;{{ item.price }}</span>
                  <span class="price-old" v-if="item.discount">
                    &#2547;{{ item.sale_price }}</span
                  >

                  <span v-if="item.discount > 0" class="best_selling_discount">
                    <!-- <p><i class="fa fa-star best_s_star"> </i></p> -->
                    <div class="star-icon" style="margin-top:-7px; margin-bottom: -32px">
                      <i class="fa fa-star" aria-hidden="true"></i>
                      <span style="margin-left:-3px">
                        <i class="fa fa-star" aria-hidden="true"></i>
                      </span>
                    </div>
                    <div class="discount-item" style="margin-top: 6px;">
                      {{ ((item.discount / item.sale_price) * 100).toFixed(0) }}%
                      <span class="d_off">off</span>
                    </div>
                    
                  </span>
                </p>
              </div>
            </div>
          </div>
        </div>
      </template>
    </vue-horizontal-list>
  </div>
</template>

<script>
import VueHorizontalList from "vue-horizontal-list";
export default {
  created() {
    this.$store.dispatch("best_selling_produtcs");
  },
  computed: {
    best_selling_produtcs() {
      return this.$store.getters.best_selling_produtcs;
    },
  },
  data() {
    return {
      base_url: this.$store.state.thumbnail_img_base_link,
      best_selling_options: {
        responsive: [
          { end: 450, size: 3 },
          { start: 450, end: 768, size: 4 },
          { start: 768, end: 992, size: 4 },
          { size: 6 },
        ],
        list: {
          windowed: 600,
          padding: 24,
        },
        position: {
          start: 0,
        },
      },
    };
  },
  components: {
    VueHorizontalList,
  },
};
</script>