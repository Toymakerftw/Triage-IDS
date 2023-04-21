import unittest
from dump import analyze_pcap

class TestDump(unittest.TestCase):
    def test_analyze_pcap(self):
        pcap_file = "test.pcap"
        expected_output = ["192.168.1.1", "192.168.1.2"]
        actual_output = analyze_pcap(pcap_file)
        self.assertEqual(expected_output, actual_output)

if __name__ == '__main__':
    unittest.main()
