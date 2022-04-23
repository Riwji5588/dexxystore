async function sendline(message = "", token = "") {
  let tokenList = token.split(",") || [];

  console.log(message);

  try {
    if (tokenList.length > 0 && message.length > 0) {
      tokenList.forEach(async (token) => {
        let url = "api/line/?token=" + token + "&message=" + message;
        let response = await $.ajax({
          url: url,
          type: "GET",
        });
        console.log(response);
      });
    } else {
      throw new Error("token or message is empty");
    }
  } catch (e) {
    console.log(e);
  }

  //   try {
  //     if (tokenList.length > 0 && message.length > 0) {
  //       tokenList.forEach(async (token) => {
  //         let url =
  //           "https://script.google.com/macros/s/AKfycbx3Hf05ha2eiouI7gG1mf1HV-7ALswtHjeOJDfwaosiDcBwdwkaqaAzgnXmxBBYREID/exec?token=" +
  //           token +
  //           "&message=" +
  //           message;
  //         let response = await $.ajax({
  //           url: url,
  //           type: "GET",
  //           crossDomain: true,
  //           headers: {
  //             "Access-Control-Allow-Credentials": true,
  //             "Access-Control-Allow-Origin": "*",
  //             "Access-Control-Allow-Methods": "GET",
  //             "Access-Control-Allow-Headers": "application/json",
  //           },
  //         });
  //         console.log(response);
  //       });
  //     } else {
  //       throw new Error("token or message is empty");
  //     }
  //   } catch (e) {
  //     console.log(e);
  //   }
}
