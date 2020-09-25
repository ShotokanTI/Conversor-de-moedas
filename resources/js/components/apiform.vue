<template>
  <div id="app">
    {{ PegarCotacaoBaseMoeda() }}
    {{ PegarCotacaoDireita() }}
    <div style="text-align: center">
      Valor a ser convertido :
      <input
        v-on:keydown="PegarCotacaoBaseMoeda(), PegarCotacaoDireita()"
        type="number"
        v-model="ValorBase"
      />

      <select @change="PegarCotacaoBaseMoeda()" v-model="moedaBaseSelected">
        <option value="BRL">BRL</option>
        <option>CAD</option>
        <option>USD</option>
      </select>
      <img
        src="https://financeone.com.br/wp-content/plugins/conversor-de-moedas/assets/imagens/seta-vai-volta.png"
        alt=""
      />
      <select @change="PegarCotacaoBaseMoeda()" v-model="moedaCotacaoSelected">
        <option>BRL</option>
        <option>CAD</option>
        <option value="USD">USD</option>
      </select>

      <h1>{{ ValorBase }} {{ moedaBaseSelected }} = {{ ValorConvertido }}</h1>

      <p>1 {{ moedaBaseSelected }} = {{ cotacaoMoedaOrigem }}</p>
      <p>1 {{ moedaCotacaoSelected }} = {{ cotacaoMoedaDestino }}</p>
      <p>Convertido em : {{ exibirTempoAtual() }}</p>
      <button v-on:click="salvarConversoesTabela()">Salvar conversao</button>
    </div>
    <table style="margin-top: 3vw" class="table">
      <thead>
        <tr>
          <th scope="col">Email do usuario</th>
          <th scope="col">Valor base</th>
          <th scope="col">Moeda Base</th>
          <th scope="col">Moeda destino</th>
          <th scope="col">Valor convertido</th>
          <th scope="col">Cotação moeda base</th>
          <th scope="col">Cotação moeda destino</th>
          <th scope="col">Convertido em</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="post in conversoesData.data" :key="post.id">
          <td>{{ post.email }}</td>
          <td>{{ post.value_before_convertion }}</td>
          <td>{{ post.currency_origin }}</td>
          <td>{{ post.target_currency }}</td>
          <td>{{ post.value_after_convertion }}</td>
          <td>{{ post.target_currency_quote }}</td>
          <td>{{ post.source_currency_quote }}</td>
          <td>{{ post.created_at }}</td>
        </tr>
      </tbody>
    </table>

    <pagination :data="conversoesData" @pagination-change-page="getResults">
    </pagination>
  </div>
</template>

<script>
export default {
  props: ["cotacaostore", "cotacaoshow"],
  data() {
    return {
      ValorBase: 1,
      moedaBaseSelected: "BRL",
      moedaCotacaoSelected: "USD",
      ValorConvertido: 0,
      cotacaoMoedaOrigem: 0,
      cotacaoMoedaDestino: 0,
      conversoesData: {},
    };
  },
  mounted() {
    this.getResults();
  },
  methods: {
    getResults(page = 1) {
      axios.get(this.cotacaoshow + "?page=" + page).then((response) => {
        this.conversoesData = response.data;
        console.log(this.conversoesData);
      });
    },
    salvarConversoesTabela() {
      alert('Conversao realizada')
      let url = this.cotacaostore;
      let token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
      fetch(url, {
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json, text-plain, */*",
          "X-Requested-With": "XMLHttpRequest",
          "X-CSRF-TOKEN": token,
        },
        method: "POST",
        credentials: "same-origin",
        body: JSON.stringify({
          email: "",
          value_before_convertion: this.ValorBase,
          currency_origin: this.moedaBaseSelected,
          target_currency: this.moedaCotacaoSelected,
          value_after_convertion: this.ValorConvertido,
          target_currency_quote: `1 ${this.moedaBaseSelected} = ${this.cotacaoMoedaOrigem} ${this.moedaCotacaoSelected}`,
          source_currency_quote: `1 ${this.moedaCotacaoSelected} = ${this.cotacaoMoedaDestino} ${this.moedaBaseSelected}`,
        }),
      });
    },
    exibirTempoAtual() {
      let time = new Date();
      return time.toLocaleString();
    },
    moedaFormato(data, moeda) {
      let formato = {
        USD: "en-US",
        BRL: "pt-BR",
        CAD: "en-CA",
      };
      return data.toLocaleString(formato[moeda], {
        style: "currency",
        currency: moeda,
      });
    },
    PegarCotacaoDireita() {
      fetch(
        "https://api.exchangeratesapi.io/latest?base=" +
          this.moedaCotacaoSelected
      )
        .then((res) => res.json())
        .then((data) => this.PegarConversao(data));
    },
    PegarConversao(data) {
      for (let i in data.rates) {
        if (i === this.moedaBaseSelected) {
          this.cotacaoMoedaDestino = this.moedaFormato(
            data.rates[i],
            this.moedaBaseSelected
          );
        }
      }
    },
    PegarCotacaoBaseMoeda() {
      fetch(
        "https://api.exchangeratesapi.io/latest?base=" + this.moedaBaseSelected
      )
        .then((res) => res.json())
        .then((data) => this.CalcularConversao(data));
    },
    CalcularConversao(data) {
      for (let i in data.rates) {
        if (i === this.moedaCotacaoSelected) {
          this.cotacaoMoedaOrigem = this.moedaFormato(
            data.rates[i],
            this.moedaCotacaoSelected
          );
          let valorConvertido = data.rates[i] * this.ValorBase;
          this.ValorConvertido = this.moedaFormato(
            valorConvertido,
            this.moedaCotacaoSelected
          );
        }
      }
    },
  },
};
</script>