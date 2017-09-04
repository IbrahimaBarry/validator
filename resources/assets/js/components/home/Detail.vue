<template>
  <div class="modal is-active">
    <div class="modal-background"></div>
    <div class="modal-content box">
      <h2 class="is-2">Informations</h2>
      <hr>
      <table class="table">
        <tbody>
          <tr>
            <td>Nom :</td>
            <td>{{ document.import.scan.reception.document.name }}</td>
          </tr>
          <tr>
            <td>Source :</td>
            <td>{{ document.import.scan.reception.document.source }}</td>
          </tr>
          <tr>
            <td>Source name :</td>
            <td>{{ document.import.scan.reception.document.sourceName }}</td>
          </tr>
          <tr>
            <td>Type :</td>
            <td>{{ document.import.scan.reception.document.type }}</td>
          </tr>
          <tr>
            <td>Fréquence :</td>
            <td>{{ document.import.scan.reception.document.frequence }}</td>
          </tr>
          <tr>
            <td>Langue :</td>
            <td>{{ document.import.scan.reception.document.lang }}</td>
          </tr>
          <tr>
            <td>Nombre de page :</td>
            <td>{{ document.import.scan.reception.nbrPage }}</td>
          </tr>
          <tr>
            <td>Date de publication :</td>
            <td>{{ document.import.scan.reception.sourceDate }}</td>
          </tr>
          <tr>
            <td>Date de reception :</td>
            <td>{{ document.import.scan.reception.created_at }}</td>
          </tr>
          <tr>
            <td>Date de scanne :</td>
            <td>{{ document.import.scan.date_scan }}</td>
          </tr>
          <tr>
            <td>Scanne confirmé par :</td>
            <td>{{ document.import.scan.admin }}</td>
          </tr>
          <tr>
            <td>Date d'import :</td>
            <td>{{ document.import.date_import }}</td>
          </tr>
          <tr>
            <td>Import confirmé par :</td>
            <td>{{ document.import.admin }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <button class="modal-close is-large" aria-label="close" @click.prevent="close"></button>
  </div>
</template>

<script>
  export default {
    props: {
      document: Object
    },

    methods: {
      close() {
        this.$emit('closeDetail')
      }
    }
  }
</script>