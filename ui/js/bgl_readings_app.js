class BglReadingsApp extends React.Component {
  render() {
    return (
        <div>
          <div>
            <h1>BGL Readings Log</h1>
          </div>
          <HeaderBar />
          <div>
            <table>
              <tbody>
                <tr><th>Date</th><th>Fasting BGL</th></tr>
                <LogReadings />
              </tbody>
            </table>
          </div>
        </div>
    );
  }
}