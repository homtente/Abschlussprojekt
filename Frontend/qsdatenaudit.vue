<template id=datenaudit>
    <div class="datenaudit_container">
        <div class="pid_container">
        <loader v-if="isloading"/>
        <PID_Abfrage/>
        
        </div>
        <div class="dmc_container">
        <DMC/>
        </div>
        <div class="right_container">
        <SCREW class="screwcontainer"/>
        <INTERVENTIONS class="interventionscontainer"/>
        </div>
        
    </div>
    
</template>

<script>

import PID_Abfrage from "./components/PID_Abfrage.vue"
import DMC from "./components/dmc.vue"
import SCREW from "./components/schraubwerte.vue"
import INTERVENTIONS from "./components/abwahlen.vue"
import loader from "../../assets/components/loader/loader.widget.vue"
 

export default {
    name: 'datenaudit',
    props:[],
    components: {
        PID_Abfrage,
        DMC,
        SCREW,
        INTERVENTIONS,
        loader
    },
    data() {
        return {  
        
        };
    },
    created(){
// Nötig um die Backgroundcolor zu ändern, da sie sonst überschrieben wird auch mit important
        document.getElementById('body').style.backgroundColor='#F0F1F2';

    },
    mounted(){
        
    },
    methods:{

    },

    // Überwachung der Variable isloading im store für anzeige des loadingscreens, wird in der API Function gesetzt
    computed:{
        isloading() {
            return this.$store.state.store_datenaudit.isloading;
        }
    },
    watch:{

    }
};
</script>

<style scoped>
.datenaudit_container{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    grid-template-rows: auto 1fr;
}
.pid_container{
    grid-column: 1 / -1;
    width: 100%;
}
.dmc_container {
    grid-column: 1 / 4;
    grid-row: 2;
    width: 100%;
}
.right_container {
    grid-column: 4;
    grid-row: 2;
    display: flex;
    flex-direction: column;
}
.screwcontainer, .interventionscontainer{
    width: 100%;
    height: 100%;
    box-sizing: border-box;
}
</style>