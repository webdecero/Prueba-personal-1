db.createUser({
user:"api-biometrics-net",
pwd:  passwordPrompt(),   // or cleartext password
roles: [ { role: "readWrite", db: "api-biometrics-net" }]
})
