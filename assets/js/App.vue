<template>
    <div id="app">
        <DxPopup
            title="Message"
            :visible="isPopupVisible"
            @hiding="showRow"
            :width="400"
            :height="200"
        >
            <p>Id: {{ popupTitle }}</p>
            <p>Message: {{ popupContent }}</p>
        </DxPopup>
        <DxDataGrid 
            id="list"
            keyExpr="id"
            :data-source="messages"
            @row-inserted="insertRow"
            :focused-row-enabled="true"
            @row-dbl-click="showRow"
        >
            <DxEditing
                mode="popup"
                :allow-adding="true">
                <DxPopup
                    :show-title="true"
                    :maxWidth="300"
                    :maxHeight="250"
                    title="Dodaj wiadomość"
                />
                <DxForm>
                    <DxSimpleItem data-field="content" editor-type="dxTextArea" :editor-options="{ width: 150 }" />
                </DxForm>
            </DxEditing>

            <DxSearchPanel :visible="true" />
            <DxToolbar>
                <DxItem name="addRowButton" show-text="always" />
                <DxItem name="searchPanel" />
            </DxToolbar>
            
            <DxColumn data-field="id" :allow-editing="false" />
            <DxColumn data-field="content" />
            <DxColumn data-field="createdAt" :allow-editing="false" />

            <DxColumn type="">
                <DxButton text="Show" @click="showRow" />
            </DxColumn>
        </DxDataGrid>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import 'devextreme/dist/css/dx.light.css';
import DxDataGrid, { 
    DxColumn,
    DxEditing,
    DxItem,
    DxForm,
    DxToolbar,
    DxFilterRow,
    DxSearchPanel
} from 'devextreme-vue/data-grid';
import { DxSimpleItem } from 'devextreme-vue/form';
import 'devextreme-vue/text-area';

import { DxButton } from 'devextreme-vue/button';
import { DxPopup } from 'devextreme-vue/popup';

const messages = ref([]);
const [popupTitle, popupContent] = [ref(null), ref(null)];
const isPopupVisible = ref(false);

const fetchMessages = () => {
    axios.get(
        '/api/messages'
    ).then(
        response => {
            messages.value = response.data;
        }
    )
    .catch(
        error => {
            console.error(error);
        }
    );
};

const insertRow = (event) => {
    axios.post('/api/message', event.data.content, {
        headers: {
            'Content-Type': 'application/json',
        }
    }).then(response => {
        fetchMessages();
    })
    .catch(error => {
        console.error(error);
    });
};

const showRow = (event) => {
	isPopupVisible.value = !isPopupVisible.value;
    popupTitle.value = event.data.id;
    popupContent.value = event.data.content;
};

onMounted(fetchMessages);
</script>

<style>
    body, .dx-viewport {
        background: #ddd;
    }
    #app {
        background: #fff;
        margin: 2rem 0 4rem 0;
        padding: 1rem;
        padding-top: 0;
        position: relative;
        box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 2.5rem 5rem 0 rgba(0, 0, 0, 0.1);
    }
    @media screen and (min-width: 550px) {
        #app {
        padding: 4rem;
        }
    }
    #app > * {
        max-width: 50rem;
        margin-left: auto;
        margin-right: auto;
    }
    #app > form {
        max-width: 100%;
    }
    #app h1 {
        display: block;
        min-width: 100%;
        width: 100%;
        text-align: center;
        margin: 0;
        margin-bottom: 1rem;
    }
</style>
