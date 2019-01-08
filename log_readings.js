class LogReadings extends React.Component {
  componentDidMount() {
      ajax("GET", "./readings.php?user_id=1", function() {
        console.log("success");
      }, function() {
        console.log("error");
      });
  }
  
  render() {
    return (
      <tr>
        <td>01/08/2019</td>
        <td>170</td>
      </tr>
    );
  }
}