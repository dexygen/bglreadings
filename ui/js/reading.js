class Reading extends React.Component {
  render() {
    return (
      <tr><td>{this.props.date}</td><td>{this.props.reading}</td></tr>
    );
  }
}