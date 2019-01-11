class Reading extends React.Component {
  deleteReading = () => {
    this.setState({mode: "delete", user_id: 1, reading_id: this.props.readingId}, () => {
      ajax("POST", "./api/readings.php", 
        (xhrResponse) => {
          this.props.updateLogReadings(JSON.parse(xhrResponse).readings);
        }, 
        () => {
          console.log("error3");
        }, 
        this.state
      );        
    }); 
  }
  
  render() {
    return (
      <tr>
        <td><a href="#" onClick={this.deleteReading}>Delete</a></td>
        <td><a href="#">Edit</a></td>
        <td>{this.props.reading_date}</td>
        <td>{this.props.reading}</td>
      </tr>
    );
  }
}