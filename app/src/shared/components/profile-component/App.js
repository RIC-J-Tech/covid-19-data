import React from "react";
// import "./index.css";
import RussBusiness  from "../../components/profile-component/RussBusiness";
import Grid  from "@material-ui/core/Grid";
import { createMuiTheme } from "@material-ui/core/styles";
import grey from "@material-ui/core/colors/grey";
import Card from "@material-ui/core/Card";



export default function App(business,behaviors) {
  return (


    <Grid container spacing={4}>
      <Grid item xs={2} sm={2} md={2}>
<RussBusiness />
      </Grid>
    </Grid>
  );
}
