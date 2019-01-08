class LogReadings extends React.Component {
  componentDidMount() {
      ajax("GET", "./readings.php", function() {
        console.log("success");
      }, function() {
        console.log("error");
      });
  }
  
  render() {
    return (
      <tr>
        <td>01/08/2019</td>
        <td>1??</td>
      </tr>
    );
  }
}