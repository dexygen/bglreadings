class Reading extends React.Component {
  render() {
    return (
      <tr>
        <td><a href="#">Delete</a></td>
        <td><a href="#">Edit</a></td>
        <td>{this.props.reading_date}</td>
        <td>{this.props.reading}</td>
      </tr>
    );
  }
}