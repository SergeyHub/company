export async function getActiveCountries() {
  return await this.$axios.get('/api/countries')
}
