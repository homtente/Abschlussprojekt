<template>
    <div class="abwahlen">
        <h2>Abwahlen</h2>
        <!-- Wenn Daten vorhanden sind -->
        <div v-if="currentInterventionsdatavorhanden" class="datatrue">
                <interventions_svg class="interventionicon"/>
            <div v-if="currentInterventions === null">
                <h5> Keine Abwahlen für diese PID im System hinterlegt</h5>
            </div>
            <!-- Fehlendes Handling, wenn Abwahlen enthalten sind Offener Punkt-->
        </div>
        <div v-else class="datafalse">
            <h5> Keine Daten vorhanden </h5>
            <interventions_svg class="interventionicon"/>
        </div>
    </div>

</template>

<script>
import interventions_svg from './interventions_svg.vue';
export default {
    name: 'abwahlen',
    components: {
        interventions_svg,
    },
    data() {
        return {
            data_vorhanden: false,
            
        };
    },

    methods:{
    
    },
    computed:{
        currentInterventions() {
            return this.$store.getters['store_datenaudit/get_interventions']
        },

        currentInterventionsdatavorhanden(){
            return this.currentInterventions !== '';
        }

    },
};
</script>


<style scoped>
.abwahlen {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;

}
.datafalse {
    border: 5px solid;
    border-color: var(--system-red-500);
    width: 80%;
    height: 80%;
}
.datatrue {
    border: 5px solid;
    border-color: var(--system-green-500);
    width: 80%;
    height: 80%;
}
.interventionicon {
    margin-top: 15%;
}

</style>



