class Reading extends React.Component {
  render() {
    return (
      <tr><td>{this.props.reading_date}</td><td>{this.props.reading}</td></tr>
    );
  }
}