<template>
    <section class="hero is-dark is-light is-bold">
        <div class="hero-body shrimp-image">
            <div class="container">
                <div class="image-align">
                <h1 class="title">
                    Dwarf shrimps in aquarium
                </h1>
                <figure class="image is-128x128">
                    <img class="is-rounded" :src="require('../img/shrimp-image.png')">
                </figure>

                </div>

                <p>
                    Keeping shrimps in the aquarium has become popular. It consists of several different things - the
                    original appearance of the shrimps and the interesting lifestyle they lead, as well as the ease of
                    growing them, thanks to the small requirements that these creatures have.


                </p>
                <br>
                <h2 class="subtitle">What is ShrimpKeeper ?</h2>
                <p>
                    ShrimpKeeper is a tool that will help you run a shrimp farm at home, by saving water measurements you will notice how your
                    aquarium changes over time, you'll be able to notice the approaching problems and see the life cycle
                    of your aquarium from start to restart.
                </p>
                 <br>
                <h2 class="subtitle">
                    Try ShrimpKeeper. Use Demo button in Login section.
                </h2>

            </div>
        </div>
    </section>

</template>
<style scoped>
.hero-body {
    opacity: 0.9;
}
/*.shrimp-image::after {
  content: "";
background: url("../img/shrimp-image.png") no-repeat;

    background-attachment: scroll;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  position: absolute;
  z-index: -1;
}*/
.hero.is-dark .title {
    text-shadow: 2px 2px 5px black;

}
p {
    text-shadow: 2px 2px 2px black;
}
.subtitle {
    text-shadow: 2px 2px 5px black;
    opacity: 1;
}
.image {
    display: inline-block;
    padding-top: 55px;
}
h1 {
    display: inline-block;
}
</style>
